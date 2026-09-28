<?php

namespace Tests\Feature;

use App\Console\Commands\NotionSyncArticles;
use App\Models\Post;
use Database\Factories\AdminFactory;
use Database\Factories\PostFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;
use Tests\TestCase;

/**
 * Machine à articles (28/09/2026) : Notion → blog neogtb.fr.
 *
 * L'API Notion est simulée par Http::fake() avec la forme de ses réponses
 * (version 2025-09-03). Ce que ces tests verrouillent :
 * - seules les pages « Blog NeoGTB » + « Validé » sont demandées à Notion
 *   (les pages « Blog » sont celles d'eynor.fr) ;
 * - date passée : article en ligne, Notion « Publié » avec son adresse ;
 * - date future : article invisible (draft), Notion « Programmé » ;
 * - le jour venu, l'article est publié côté site, même si Notion ne répond
 *   pas, puis sa page Notion passe « Publié » ;
 * - « Publié » n'est jamais écrit pour un article absent ou pas encore visible ;
 * - la synchro est idempotente, ne change jamais l'URL, ne vole aucun slug ;
 * - le HTML produit passe le filtre Purify de la page article sans perte.
 */
class NotionSyncArticlesTest extends TestCase
{
    use RefreshDatabase;

    private const PAGE_ID = '11111111-2222-3333-4444-555555555555';

    /** @var array<int, Request> */
    private array $patches = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        config([
            'services.notion.token' => 'ntn_test',
            'services.notion.blog_data_source_id' => 'ds-blog',
            'services.notion.platform' => 'Blog NeoGTB',
            'services.notion.default_category' => 'Guide',
        ]);

        AdminFactory::new()->create(['email' => 'admin@neogtb.fr']);
        config(['services.notion.sync_author_email' => 'admin@neogtb.fr']);
    }

    // ------------------------------------------------------------------
    // Fabrique de réponses Notion
    // ------------------------------------------------------------------

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function page(array $overrides = []): array
    {
        $text = fn (string $v) => ['type' => 'rich_text', 'rich_text' => $v === '' ? [] : [['plain_text' => $v]]];

        return ['object' => 'page', 'id' => self::PAGE_ID, 'properties' => [
            NotionSyncArticles::P_TITLE => ['type' => 'title', 'title' => [['plain_text' => $overrides['title'] ?? 'Réception d\'une GTB : la liste de contrôle']]],
            NotionSyncArticles::P_PLATFORM => ['type' => 'select', 'select' => ['name' => 'Blog NeoGTB']],
            NotionSyncArticles::P_STAGE => ['type' => 'select', 'select' => ['name' => $overrides['stage'] ?? 'Validé']],
            NotionSyncArticles::P_DATE => ['type' => 'date', 'date' => ['start' => $overrides['date'] ?? '2026-09-01']],
            NotionSyncArticles::P_CATEGORY => ['type' => 'select', 'select' => isset($overrides['category']) ? ['name' => $overrides['category']] : null],
            NotionSyncArticles::P_SLUG => $text($overrides['slug'] ?? 'reception-gtb-liste-controle'),
            NotionSyncArticles::P_META_TITLE => $text('Réception GTB : la liste de contrôle'),
            NotionSyncArticles::P_META_DESCRIPTION => $text('Avant de signer le PV de réception d\'une GTB : points de contrôle.'),
            NotionSyncArticles::P_EXCERPT => $text(''),
            NotionSyncArticles::P_IMAGE => ['type' => 'url', 'url' => $overrides['image'] ?? null],
        ]];
    }

    /**
     * @param  array<int, array<string, mixed>>  $richText
     * @param  array<string, mixed>  $extra
     * @return array<string, mixed>
     */
    private function block(string $type, array $richText = [], array $extra = []): array
    {
        static $n = 0;
        $n++;

        return array_merge([
            'object' => 'block',
            'id' => sprintf('bbbbbbbb-0000-0000-0000-%012d', $n),
            'type' => $type,
            'has_children' => false,
            'last_edited_time' => '2026-09-28T10:00:00.000Z',
            $type => ['rich_text' => $richText],
        ], $extra);
    }

    /**
     * @param  array<string, mixed>  $annotations
     * @return array<string, mixed>
     */
    private function rt(string $text, array $annotations = [], ?string $href = null): array
    {
        return ['plain_text' => $text, 'href' => $href, 'annotations' => $annotations];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function articleBlocks(): array
    {
        return [
            $this->block('paragraph', [$this->rt('Avant de signer le PV, vérifiez la '), $this->rt('supervision', ['bold' => true]), $this->rt('. C\'est l\'exploitant qui vivra avec.')]),
            $this->block('heading_1', [$this->rt('Les points de contrôle')]),
            $this->block('bulleted_list_item', [$this->rt('Points de mesure remontés')]),
            $this->block('bulleted_list_item', [$this->rt('Voir la '), $this->rt('page interne', [], '/0123456789abcdef0123456789abcdef'), $this->rt(' et '), $this->rt('le décret', [], 'https://www.legifrance.gouv.fr/')]),
            $this->block('callout', [$this->rt('En pratique. Une sonde de reprise inversée.')]),
            $this->block('paragraph', [$this->rt('<script>alert(1)</script>')]),
            $this->block('heading_2', [$this->rt('FAQ')]),
        ];
    }

    /**
     * Notion simulé qui répond selon l'étape demandée dans le filtre.
     *
     * @param  array<int, array<string, mixed>>  $validated
     * @param  array<int, array<string, mixed>>  $scheduled
     * @param  array<int, array<string, mixed>>|null  $blocks
     * @param  array<string, mixed>  $extra
     */
    private function fakeNotion(array $validated, array $scheduled = [], ?array $blocks = null, array $extra = []): void
    {
        $this->patches = [];
        $blocks ??= $this->articleBlocks();

        // Un second Http::fake() empile ses réponses DERRIÈRE les premières :
        // on repart d'un client neuf pour que chaque scénario soit le seul servi.
        Http::swap(new Factory(app('events')));
        Http::fake(array_merge($extra, [
            'api.notion.com/v1/data_sources/*/query' => function (Request $request) use ($validated, $scheduled) {
                $stage = $request->data()['filter']['and'][1]['select']['equals'] ?? null;

                return Http::response(['results' => $stage === 'Programmé' ? $scheduled : $validated, 'has_more' => false]);
            },
            'api.notion.com/v1/blocks/'.self::PAGE_ID.'/children*' => Http::response(['results' => $blocks, 'has_more' => false]),
            'api.notion.com/v1/pages/*' => function (Request $request) {
                if ($request->method() === 'PATCH') {
                    $this->patches[] = $request;
                }

                return Http::response(['object' => 'page']);
            },
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    private function patchedProps(int $index = 0): array
    {
        return $this->patches[$index]->data()['properties'];
    }

    // ------------------------------------------------------------------
    // Tests
    // ------------------------------------------------------------------

    public function test_une_page_validee_datee_du_passe_est_en_ligne_et_notion_dit_publie(): void
    {
        $this->fakeNotion([$this->page()]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $post = Post::where('notion_page_id', self::PAGE_ID)->firstOrFail();
        $this->assertSame('published', $post->status);
        $this->assertFalse($post->notion_scheduled);
        $this->assertSame('reception-gtb-liste-controle', $post->slug);
        $this->assertSame('2026-09-01', $post->published_at->toDateString());
        $this->assertSame('Guide', $post->category?->name);
        $this->assertSame('admin@neogtb.fr', $post->author->email);
        $this->assertSame('Avant de signer le PV, vérifiez la supervision. C\'est l\'exploitant qui vivra avec.', $post->excerpt);

        $this->assertCount(1, $this->patches);
        $props = $this->patchedProps();
        $this->assertSame('Publié', $props['Étape blog']['select']['name']);
        $this->assertStringEndsWith('/blog/reception-gtb-liste-controle', $props['URL publiée']['url']);
        $this->assertStringStartsWith('Publié le ', $props['Journal synchro']['rich_text'][0]['text']['content']);

        $this->get('/blog/reception-gtb-liste-controle')->assertOk();
    }

    public function test_une_date_future_programme_l_article_sans_le_montrer(): void
    {
        $date = now()->addDays(10)->toDateString();
        $this->fakeNotion([$this->page(['date' => $date])]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $post = Post::firstOrFail();
        $this->assertSame('draft', $post->status);
        $this->assertTrue($post->notion_scheduled);
        $this->get('/blog/reception-gtb-liste-controle')->assertNotFound();

        $props = $this->patchedProps();
        $this->assertSame('Programmé', $props['Étape blog']['select']['name']);
        $this->assertStringEndsWith('/blog/reception-gtb-liste-controle', $props['URL publiée']['url']);
        $this->assertStringStartsWith('Programmé pour le ', $props['Journal synchro']['rich_text'][0]['text']['content']);
    }

    public function test_le_jour_venu_l_article_est_publie_puis_notion_passe_publie(): void
    {
        $post = PostFactory::new()->create([
            'status' => 'draft',
            'published_at' => now()->subHour(),
        ]);
        $post->forceFill(['notion_page_id' => self::PAGE_ID, 'notion_scheduled' => true])->save();
        $this->fakeNotion([], [$this->page(['stage' => 'Programmé'])]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertFalse($post->notion_scheduled);

        $this->assertCount(1, $this->patches);
        $props = $this->patchedProps();
        $this->assertSame('Publié', $props['Étape blog']['select']['name']);
        $this->assertStringStartsWith('Publié le '.now()->subHour()->format('d/m/Y'), $props['Journal synchro']['rich_text'][0]['text']['content']);
    }

    public function test_l_article_sort_a_sa_date_meme_si_notion_ne_repond_pas(): void
    {
        $post = PostFactory::new()->create(['status' => 'draft', 'published_at' => now()->subHour()]);
        $post->forceFill(['notion_page_id' => self::PAGE_ID, 'notion_scheduled' => true])->save();

        Http::swap(new Factory(app('events')));
        Http::fake(['api.notion.com/v1/data_sources/*/query' => function (Request $request) {
            $stage = $request->data()['filter']['and'][1]['select']['equals'] ?? null;

            return $stage === 'Programmé'
                ? Http::response(['object' => 'error'], 502)
                : Http::response(['results' => [], 'has_more' => false]);
        }]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->assertSame('published', $post->refresh()->status);
    }

    public function test_un_article_programme_pas_encore_date_reste_invisible_et_programme(): void
    {
        $post = PostFactory::new()->create(['status' => 'draft', 'published_at' => now()->addDays(3)]);
        $post->forceFill(['notion_page_id' => self::PAGE_ID, 'notion_scheduled' => true])->save();
        $this->fakeNotion([], [$this->page(['stage' => 'Programmé'])]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->assertSame('draft', $post->refresh()->status);
        $this->assertSame([], $this->patches);
    }

    public function test_un_brouillon_mis_a_la_main_n_est_jamais_publie_par_la_machine(): void
    {
        // Brouillon posé dans l'admin, sans marque « programmé » : la machine n'y touche pas.
        $post = PostFactory::new()->create(['status' => 'draft', 'published_at' => now()->subDay()]);
        $post->forceFill(['notion_page_id' => self::PAGE_ID, 'notion_scheduled' => false])->save();
        $this->fakeNotion([], [$this->page(['stage' => 'Programmé'])]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->assertSame('draft', $post->refresh()->status);
        $this->assertSame([], $this->patches);
    }

    public function test_un_article_programme_absent_du_site_n_est_jamais_dit_publie(): void
    {
        $this->fakeNotion([], [$this->page(['stage' => 'Programmé'])]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->assertSame([], $this->patches);
    }

    public function test_le_dry_run_n_ecrit_rien_nulle_part(): void
    {
        $post = PostFactory::new()->create(['status' => 'draft', 'published_at' => now()->subDay()]);
        $post->forceFill(['notion_page_id' => '99999999-2222-3333-4444-555555555555', 'notion_scheduled' => true])->save();
        $this->fakeNotion([$this->page()], [$this->page(['stage' => 'Programmé'])]);

        $this->artisan('notion:sync-articles', ['--dry-run' => true])->assertSuccessful();

        $this->assertSame(1, Post::count());
        $this->assertSame('draft', $post->refresh()->status);
        $this->assertSame([], $this->patches);
    }

    public function test_seules_les_pages_blog_neogtb_sont_demandees_a_notion(): void
    {
        $this->fakeNotion([$this->page()]);
        $this->artisan('notion:sync-articles')->assertSuccessful();

        Http::assertSent(function (Request $request) {
            if (! str_contains($request->url(), '/data_sources/ds-blog/query')) {
                return false;
            }
            $filters = $request->data()['filter']['and'];

            return $request->hasHeader('Notion-Version', '2025-09-03')
                && $filters[0] === ['property' => 'Plateforme', 'select' => ['equals' => 'Blog NeoGTB']]
                && $filters[1] === ['property' => 'Étape blog', 'select' => ['equals' => 'Validé']];
        });
    }

    public function test_la_synchro_est_idempotente_et_ne_change_jamais_l_url(): void
    {
        $this->fakeNotion([$this->page()]);
        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->fakeNotion([$this->page(['title' => 'Nouveau titre', 'slug' => 'autre-adresse', 'category' => 'Réglementation'])]);
        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->assertSame(1, Post::count());
        $post = Post::firstOrFail();
        $this->assertSame('Nouveau titre', $post->title);
        $this->assertSame('reception-gtb-liste-controle', $post->slug);
        $this->assertSame('Réglementation', $post->category?->name);
    }

    public function test_le_slug_ne_vole_jamais_celui_d_un_autre_article(): void
    {
        PostFactory::new()->create(['slug' => 'reception-gtb-liste-controle']);
        $this->fakeNotion([$this->page()]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $this->assertSame('reception-gtb-liste-controle-2', Post::where('notion_page_id', self::PAGE_ID)->value('slug'));
    }

    public function test_une_page_vide_passe_en_erreur_sans_rien_publier(): void
    {
        $this->fakeNotion([$this->page()], [], []);

        $this->artisan('notion:sync-articles')->assertFailed();

        $this->assertSame(0, Post::count());
        $props = $this->patchedProps();
        $this->assertSame('Erreur', $props['Étape blog']['select']['name']);
        $this->assertStringContainsString('page sans contenu', $props['Journal synchro']['rich_text'][0]['text']['content']);
    }

    public function test_le_html_passe_le_filtre_de_la_page_article_sans_perte(): void
    {
        $table = $this->block('table', [], ['has_children' => true, 'table' => ['table_width' => 2, 'has_column_header' => true]]);
        $row = fn (string $a, string $b) => ['type' => 'table_row', 'table_row' => ['cells' => [[$this->rt($a)], [$this->rt($b)]]]];
        $blocks = array_merge($this->articleBlocks(), [$table]);

        $this->fakeNotion([$this->page()], [], $blocks, [
            'api.notion.com/v1/blocks/'.$table['id'].'/children*' => Http::response(['results' => [
                $row('Point', 'Contrôle'), $row('Sonde', 'Valeur cohérente'),
            ], 'has_more' => false]),
        ]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $html = Post::firstOrFail()->content;
        $this->assertStringContainsString('<h2>Les points de contrôle</h2>', $html);
        $this->assertStringNotContainsString('<h1', $html);
        $this->assertStringContainsString('<blockquote><p>En pratique. Une sonde de reprise inversée.</p></blockquote>', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringContainsString('Voir la page interne et ', $html);

        // Ce que la page article affiche réellement (Purify, profil par défaut) :
        // tableau, citation et liens survivent tels quels.
        $clean = Purify::clean($html);
        $this->assertStringContainsString('<blockquote><p>En pratique. Une sonde de reprise inversée.</p></blockquote>', $clean);
        $this->assertStringContainsString('<table><thead><tr><th>Point</th><th>Contrôle</th></tr></thead><tbody><tr><td>Sonde</td><td>Valeur cohérente</td></tr></tbody></table>', $clean);
        $this->assertStringContainsString('href="https://www.legifrance.gouv.fr/"', $clean);
        $this->assertStringNotContainsString('<script>', $clean);
    }

    public function test_les_images_sont_rapatriees_en_local(): void
    {
        Storage::fake('public');
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $blocks = $this->articleBlocks();
        $blocks[] = $this->block('image', [], [
            'image' => ['type' => 'file', 'file' => ['url' => 'https://prod-files-secure.s3.us-west-2.amazonaws.com/x/schema.png?X-Amz=1'], 'caption' => [$this->rt('Architecture BACnet')]],
        ]);

        $this->fakeNotion([$this->page(['image' => 'https://images.example.test/une.png'])], [], $blocks, [
            'prod-files-secure.s3.us-west-2.amazonaws.com/*' => Http::response($png, 200, ['Content-Type' => 'image/png']),
            'images.example.test/*' => Http::response($png, 200, ['Content-Type' => 'image/png']),
        ]);

        $this->artisan('notion:sync-articles')->assertSuccessful();

        $post = Post::firstOrFail();
        $this->assertMatchesRegularExpression('#<p><img src="/storage/blog/notion/[0-9a-f]+-[0-9a-f]{8}\.png" alt="Architecture BACnet"></p><p><em>Architecture BACnet</em></p>#', $post->content);
        $this->assertStringNotContainsString('amazonaws', $post->content);
        $this->assertMatchesRegularExpression('#^blog/notion/[0-9a-f]+-une-[0-9a-f]{8}\.png$#', $post->featured_image);
        Storage::disk('public')->assertExists($post->featured_image);
    }

    public function test_sans_jeton_la_commande_ne_fait_rien(): void
    {
        config(['services.notion.token' => null]);
        Http::fake();

        $this->artisan('notion:sync-articles')->assertSuccessful();

        Http::assertNothingSent();
        $this->assertSame(0, Post::count());
    }
}
