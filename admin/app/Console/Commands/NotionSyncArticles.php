<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\Notion\NotionBlocksToHtml;
use App\Services\NotionClient;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Machine à articles de blog : publie sur neogtb.fr les articles validés dans
 * Notion (base « Calendrier de contenu », la même que pour eynor.fr).
 *
 *   php artisan notion:sync-articles             # envoie les pages « Validé »
 *   php artisan notion:sync-articles --dry-run   # aperçu, rien n'est écrit
 *   php artisan notion:sync-articles --page=ID   # une page précise, quelle que soit son étape
 *
 * Parcours d'une page : Idée → Brief prêt → En rédaction → À relire → Validé
 * (geste humain d'Ulrich) → Programmé → Publié. Cette commande ne touche QUE
 * les pages dont la plateforme est « Blog NeoGTB » (config services.notion.platform),
 * eynor.fr prend celles marquées « Blog ».
 *
 * Retour dans Notion après envoi : URL, journal de synchro, et l'étape :
 * - « Programmé » si la date est future. L'article est enregistré en « draft »
 *   (invisible sur le site) avec notion_scheduled = true ;
 * - « Publié » seulement quand il est réellement visible sur neogtb.fr. Chaque
 *   passage publie les articles programmés dont la date est arrivée, puis
 *   passe leur page Notion à « Publié ».
 * En cas d'échec : étape « Erreur » et le motif dans le journal, jamais un
 * article à moitié publié.
 *
 * Idempotent : chaque Post est rattaché à son notion_page_id. Pour corriger un
 * article, le repasser à « Validé » dans Notion : le slug, donc l'URL, ne
 * change jamais.
 *
 * Images : rapatriées sur le disque public, jamais servies depuis Notion
 * (URL de fichiers Notion valables une heure).
 */
class NotionSyncArticles extends Command
{
    protected $signature = 'notion:sync-articles
                            {--dry-run : Affiche ce qui serait publié sans rien écrire}
                            {--page= : Identifiant d\'une page Notion à publier, quelle que soit son étape}';

    protected $description = 'Publie sur le blog NeoGTB les articles validés dans Notion (machine à articles)';

    /** Noms des propriétés Notion lues et écrites (base « Calendrier de contenu »). */
    public const P_TITLE = 'Titre du contenu';

    public const P_PLATFORM = 'Plateforme';

    public const P_STAGE = 'Étape blog';

    public const P_DATE = 'Date de publication';

    public const P_CATEGORY = 'Catégorie blog';

    public const P_SLUG = 'Slug';

    public const P_META_TITLE = 'Meta title';

    public const P_META_DESCRIPTION = 'Meta description';

    public const P_EXCERPT = 'Extrait';

    public const P_IMAGE = 'Image à la une';

    public const P_URL = 'URL publiée';

    public const P_LOG = 'Journal synchro';

    public const STAGE_VALIDATED = 'Validé';

    public const STAGE_SCHEDULED = 'Programmé';

    public const STAGE_PUBLISHED = 'Publié';

    public const STAGE_ERROR = 'Erreur';

    private const IMAGE_DIR = 'blog/notion';

    private const IMAGE_MAX_BYTES = 15 * 1024 * 1024;

    private const IMAGE_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        'image/avif' => 'avif',
    ];

    public function handle(NotionClient $notion): int
    {
        $dry = (bool) $this->option('dry-run');

        if (! $notion->isConfigured()) {
            $this->warn('NOTION_TOKEN absent du .env : rien à synchroniser.');

            return self::SUCCESS;
        }

        $author = $this->resolveAuthor();
        if (! $author) {
            $this->error('Aucun compte admin pour signer les articles (renseigner NOTION_SYNC_AUTHOR_EMAIL).');

            return self::FAILURE;
        }

        $pages = $this->pagesToSync($notion);
        if ($pages === null) {
            $this->error('Notion n\'a pas répondu (jeton, partage de la base avec l\'intégration ?). Voir laravel.log.');

            return self::FAILURE;
        }

        $failures = 0;

        if ($pages === []) {
            $this->info('Aucun article « Validé » à publier.');
        } else {
            $failures = $this->syncValidated($notion, $pages, $author, $dry);
        }

        // Les articles programmés dont la date est arrivée sont publiés, puis
        // passent « Publié » dans Notion. Pas avec --page : ce mode vise une page.
        if (! $this->option('page')) {
            $this->publishDueArticles($notion, $dry);
        }

        return $failures > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @return array<int, array<string, mixed>>|null
     */
    private function pagesToSync(NotionClient $notion): ?array
    {
        if ($pageId = $this->option('page')) {
            $page = $notion->getPage((string) $pageId);

            return $page === null ? null : [$page];
        }

        return $this->queryStage($notion, self::STAGE_VALIDATED);
    }

    /**
     * @return array<int, array<string, mixed>>|null
     */
    private function queryStage(NotionClient $notion, string $stage): ?array
    {
        return $notion->queryDataSource((string) config('services.notion.blog_data_source_id'), [
            'and' => [
                ['property' => self::P_PLATFORM, 'select' => ['equals' => (string) config('services.notion.platform', 'Blog NeoGTB')]],
                ['property' => self::P_STAGE, 'select' => ['equals' => $stage]],
            ],
        ]);
    }

    /**
     * Envoie sur le site les pages « Validé ». Renvoie le nombre d'échecs.
     *
     * @param  array<int, array<string, mixed>>  $pages
     */
    private function syncValidated(NotionClient $notion, array $pages, Admin $author, bool $dry): int
    {
        $this->info('Envoi de '.count($pages).' article(s) depuis Notion'.($dry ? ' (DRY-RUN)' : ''));

        $rows = [];
        $failures = 0;

        foreach ($pages as $page) {
            $pageId = (string) ($page['id'] ?? '');
            $title = $this->text($page, self::P_TITLE);

            try {
                $result = $this->syncPage($notion, $page, $author, $dry);
                $rows[] = [Str::limit($title, 50), $result['action'], $result['url'] ?? '-'];
            } catch (\Throwable $e) {
                $failures++;
                $rows[] = [Str::limit($title, 50), 'ERREUR', Str::limit($e->getMessage(), 60)];
                report($e);

                if (! $dry && $pageId !== '') {
                    $notion->updatePageProperties($pageId, [
                        self::P_STAGE => ['select' => ['name' => self::STAGE_ERROR]],
                        self::P_LOG => $this->richTextValue('Échec du '.now()->format('d/m/Y H:i').' : '.$e->getMessage()),
                    ]);
                }
            }
        }

        $this->table(['Article', 'Action', 'Adresse'], $rows);

        return $failures;
    }

    /**
     * @param  array<string, mixed>  $page
     * @return array{action: string, url?: string}
     */
    private function syncPage(NotionClient $notion, array $page, Admin $author, bool $dry): array
    {
        $pageId = (string) $page['id'];
        $title = trim($this->text($page, self::P_TITLE));

        if ($title === '') {
            throw new \RuntimeException('titre vide');
        }

        $blocks = $notion->blockChildren($pageId);
        if ($blocks === null) {
            throw new \RuntimeException('contenu de la page illisible');
        }

        $converter = new NotionBlocksToHtml(
            fn (string $id) => $notion->blockChildren($id),
            fn (array $block) => $this->storeContentImage($block, $dry),
        );
        $html = trim($converter->render($blocks));

        if (strip_tags($html) === '') {
            throw new \RuntimeException('page sans contenu : rien à publier');
        }

        $existing = Post::withTrashed()->where('notion_page_id', $pageId)->first();
        $isNew = $existing === null;

        $slug = $existing?->slug ?? $this->uniqueSlug($this->text($page, self::P_SLUG) ?: $title, $pageId);
        $publishedAt = $this->publicationDate($page);
        $scheduled = $publishedAt->isFuture();
        $excerpt = trim($this->text($page, self::P_EXCERPT)) ?: $this->firstParagraph($html);
        $metaDescription = trim($this->text($page, self::P_META_DESCRIPTION)) ?: $excerpt;

        $url = route('front.article', $slug);
        $action = ($isNew ? 'créé' : 'mis à jour').($scheduled ? ', programmé' : ', en ligne');

        if ($dry) {
            return ['action' => "{$action} (aperçu)", 'url' => $url];
        }

        $post = $existing ?? new Post;
        if ($post->trashed()) {
            $post->restore();
        }

        $post->notion_page_id = $pageId;
        $post->slug = $slug;
        $post->notion_scheduled = $scheduled;
        $post->fill([
            'title' => $title,
            'excerpt' => Str::limit($excerpt, 300) ?: null,
            'content' => $html,
            'meta_title' => Str::limit(trim($this->text($page, self::P_META_TITLE)), 70, '') ?: null,
            'meta_description' => Str::limit($metaDescription, 160) ?: null,
            'category_id' => $this->resolveCategory($this->select($page, self::P_CATEGORY))?->id,
            'author_id' => $post->author_id ?? $author->id,
            // Une date future garde l'article invisible (tout le site ne lit que
            // « published ») : publishDueArticles() le publiera le jour venu.
            'status' => $scheduled ? 'draft' : 'published',
            'published_at' => $publishedAt,
        ]);

        // Image à la une : la propriété Notion, sinon la première image du
        // contenu. Jamais écrasée par null : une image posée à la main dans
        // l'admin survit à la synchro suivante.
        $featured = $this->storeFeaturedImage($page)
            ?? (($first = $converter->images()[0] ?? null) ? Str::after($first, '/storage/') : null);
        if ($featured) {
            $post->featured_image = $featured;
        }

        $post->save();

        $when = $scheduled
            ? 'Programmé pour le '.$publishedAt->format('d/m/Y')
            : 'Publié le '.now()->format('d/m/Y à H:i');
        $warnings = $converter->warnings();
        $log = $when.' sur neogtb.fr'.($warnings === [] ? '' : ' · '.implode(', ', $warnings));

        $notion->updatePageProperties($pageId, [
            self::P_STAGE => ['select' => ['name' => $scheduled ? self::STAGE_SCHEDULED : self::STAGE_PUBLISHED]],
            self::P_URL => ['url' => $url],
            self::P_SLUG => $this->richTextValue($slug),
            self::P_LOG => $this->richTextValue($log),
        ]);

        return ['action' => $action, 'url' => $url];
    }

    /**
     * Publie les articles programmés dont la date est arrivée, puis aligne
     * Notion : « Publié » veut toujours dire « visible sur neogtb.fr ».
     *
     * 1. Côté site d'abord : la publication ne dépend pas de Notion. Si Notion
     *    ne répond pas, l'article sort quand même à sa date.
     * 2. Puis chaque page Notion encore « Programmé » dont l'article est en
     *    ligne passe « Publié » (rattrape aussi un retour Notion raté la veille).
     */
    private function publishDueArticles(NotionClient $notion, bool $dry): void
    {
        $due = Post::where('notion_scheduled', true)
            ->where('status', 'draft')
            ->whereNotNull('notion_page_id')
            ->where('published_at', '<=', now())
            ->get();

        foreach ($due as $post) {
            $this->line('Mis en ligne : '.Str::limit($post->title, 60).($dry ? ' (aperçu)' : ''));

            if (! $dry) {
                $post->status = 'published';
                $post->notion_scheduled = false;
                $post->save();
            }
        }

        $pages = $this->queryStage($notion, self::STAGE_SCHEDULED);
        if ($pages === null) {
            $this->warn('Notion n\'a pas répondu : étapes « Programmé » non mises à jour, nouvel essai au prochain passage.');

            return;
        }

        foreach ($pages as $page) {
            $pageId = (string) ($page['id'] ?? '');

            // Défensif : on ne fait confiance qu'à l'étape lue sur la page elle-même.
            if ($pageId === '' || $this->select($page, self::P_STAGE) !== self::STAGE_SCHEDULED) {
                continue;
            }

            $post = Post::where('notion_page_id', $pageId)
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->first();

            // En dry-run, l'article « dû » n'a pas été publié à l'étape 1 : on le compte quand même.
            if (! $post && $dry) {
                $post = $due->firstWhere('notion_page_id', $pageId);
            }

            if (! $post || $dry) {
                continue;
            }

            $notion->updatePageProperties($pageId, [
                self::P_STAGE => ['select' => ['name' => self::STAGE_PUBLISHED]],
                self::P_LOG => $this->richTextValue('Publié le '.$post->published_at->format('d/m/Y').' sur neogtb.fr (était programmé)'),
            ]);
        }
    }

    // ------------------------------------------------------------------
    // Lecture des propriétés Notion
    // ------------------------------------------------------------------

    /**
     * Texte brut d'une propriété titre ou texte enrichi.
     *
     * @param  array<string, mixed>  $page
     */
    private function text(array $page, string $name): string
    {
        $prop = $page['properties'][$name] ?? null;
        if (! is_array($prop)) {
            return '';
        }

        $items = $prop[$prop['type'] ?? ''] ?? [];

        return is_array($items)
            ? implode('', array_map(fn ($t) => (string) ($t['plain_text'] ?? ''), $items))
            : '';
    }

    /**
     * @param  array<string, mixed>  $page
     */
    private function select(array $page, string $name): ?string
    {
        return $page['properties'][$name]['select']['name'] ?? null;
    }

    /**
     * @param  array<string, mixed>  $page
     */
    private function publicationDate(array $page): Carbon
    {
        $start = $page['properties'][self::P_DATE]['date']['start'] ?? null;

        return $start ? Carbon::parse($start, config('app.timezone')) : now();
    }

    /**
     * @return array<string, mixed>
     */
    private function richTextValue(string $content): array
    {
        return ['rich_text' => [['type' => 'text', 'text' => ['content' => Str::limit($content, 1900)]]]];
    }

    // ------------------------------------------------------------------
    // Résolutions côté site
    // ------------------------------------------------------------------

    private function resolveAuthor(): ?Admin
    {
        if ($email = config('services.notion.sync_author_email')) {
            if ($admin = Admin::where('email', $email)->first()) {
                return $admin;
            }
            $this->warn("NOTION_SYNC_AUTHOR_EMAIL={$email} introuvable, repli sur le premier admin.");
        }

        return Admin::orderBy('id')->first();
    }

    private function resolveCategory(?string $name): ?PostCategory
    {
        $name = trim((string) ($name ?: config('services.notion.default_category')));
        if ($name === '') {
            return null;
        }

        return PostCategory::where('slug', Str::slug($name))->first()
            ?? PostCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
                'order' => (int) PostCategory::max('order') + 1,
            ]);
    }

    private function uniqueSlug(string $source, string $pageId): string
    {
        $base = Str::slug($source) ?: 'article-'.substr(str_replace('-', '', $pageId), 0, 8);
        $slug = $base;
        $i = 2;

        while (Post::withTrashed()
            ->where('slug', $slug)
            ->where(fn ($q) => $q->whereNull('notion_page_id')->orWhere('notion_page_id', '!=', $pageId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function firstParagraph(string $html): string
    {
        if (preg_match('/<p>(.*?)<\/p>/su', $html, $m)) {
            return Str::limit(trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8')), 200);
        }

        return '';
    }

    // ------------------------------------------------------------------
    // Images
    // ------------------------------------------------------------------

    /**
     * Image d'un bloc du contenu : URL publique locale, ou null.
     *
     * @param  array<string, mixed>  $block
     */
    private function storeContentImage(array $block, bool $dry): ?string
    {
        $image = $block['image'] ?? [];
        $source = ($image['type'] ?? '') === 'external'
            ? ($image['external']['url'] ?? null)
            : ($image['file']['url'] ?? null);

        if (! $source) {
            return null;
        }

        if ($dry) {
            return $source;
        }

        // Nom stable par bloc et par version du bloc : rejouer la synchro ne
        // retélécharge rien, remplacer l'image dans Notion produit un fichier neuf.
        $name = str_replace('-', '', (string) $block['id']).'-'.substr(md5((string) ($block['last_edited_time'] ?? '')), 0, 8);
        $path = $this->storeImage($source, self::IMAGE_DIR.'/'.$name);

        return $path ? '/storage/'.$path : null;
    }

    /**
     * Propriété « Image à la une » : chemin relatif au disque public, ou null.
     *
     * @param  array<string, mixed>  $page
     */
    private function storeFeaturedImage(array $page): ?string
    {
        $source = trim((string) ($page['properties'][self::P_IMAGE]['url'] ?? ''));
        if ($source === '' || ! Str::startsWith($source, ['http://', 'https://'])) {
            return null;
        }

        $name = str_replace('-', '', (string) $page['id']).'-une-'.substr(md5($source), 0, 8);

        return $this->storeImage($source, self::IMAGE_DIR.'/'.$name);
    }

    /**
     * Télécharge une image (type vérifié, 15 Mo max) et la range sur le disque
     * public. $target est sans extension : elle vient du type renvoyé.
     * Renvoie le chemin sur le disque public, ou null.
     */
    private function storeImage(string $source, string $target): ?string
    {
        foreach (self::IMAGE_EXTENSIONS as $ext) {
            if (Storage::disk('public')->exists("{$target}.{$ext}")) {
                return "{$target}.{$ext}";
            }
        }

        try {
            $response = Http::timeout(30)->retry(2, 500, throw: false)->get($source);
            $mime = strtolower(trim(Str::before((string) $response->header('Content-Type'), ';')));
            $ext = self::IMAGE_EXTENSIONS[$mime] ?? null;

            if (! $response->successful()
                || $ext === null
                || strlen($response->body()) === 0
                || strlen($response->body()) > self::IMAGE_MAX_BYTES) {
                return null;
            }

            Storage::disk('public')->put("{$target}.{$ext}", $response->body());

            return "{$target}.{$ext}";
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }
}
