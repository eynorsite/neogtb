<?php

namespace App\Services\Notion;

use Closure;

/**
 * Convertit les blocs d'une page Notion (API publique) en HTML de blog.
 *
 * Porté du site eynor.fr (même base Notion). Choix de rendu pour neogtb.fr :
 * - le titre de la page devient le H1 de l'article : un « Titre 1 » Notion est
 *   donc rendu en <h2>, jamais en second <h1> ;
 * - seules les balises autorisées par config/purify.php (profil « default »,
 *   appliqué par front/article.blade.php) sont produites : une « callout »
 *   devient <blockquote> (stylé par la classe prose), une image devient
 *   <p><img></p> avec sa légende en italique, un « toggle » devient un Titre 3
 *   suivi de son contenu (pas de <div>, <figure> ni <details>) ;
 * - tout le texte est échappé ici, les liens sont filtrés (http, https,
 *   mailto, tel, chemins relatifs) et les liens internes Notion retirés.
 *
 * Les images passent par $imageResolver, qui renvoie l'URL locale du fichier
 * rapatrié (la CSP img-src n'autorise pas les hôtes de Notion, et les URL de
 * fichiers Notion expirent au bout d'une heure) ou null pour ignorer l'image.
 */
class NotionBlocksToHtml
{
    /** @var array<int, string> blocs ignorés, pour le journal de synchro */
    private array $warnings = [];

    /** @var array<int, string> URL locales des images rendues, dans l'ordre */
    private array $images = [];

    /**
     * @param  Closure(string): (array<int, array<string, mixed>>|null)  $childrenFetcher
     * @param  Closure(array<string, mixed>): ?string  $imageResolver
     */
    public function __construct(
        private readonly Closure $childrenFetcher,
        private readonly Closure $imageResolver,
    ) {}

    /**
     * @param  array<int, array<string, mixed>>  $blocks
     */
    public function render(array $blocks, int $depth = 0): string
    {
        $html = '';
        $count = count($blocks);
        $i = 0;

        while ($i < $count) {
            $type = $blocks[$i]['type'] ?? '';

            if (in_array($type, ['bulleted_list_item', 'numbered_list_item', 'to_do'], true)) {
                $tag = $type === 'numbered_list_item' ? 'ol' : 'ul';
                $items = '';
                while ($i < $count && ($blocks[$i]['type'] ?? '') === $type) {
                    $items .= $this->listItem($blocks[$i], $depth);
                    $i++;
                }
                $html .= "<{$tag}>{$items}</{$tag}>";

                continue;
            }

            $html .= $this->block($blocks[$i], $depth);
            $i++;
        }

        return $html;
    }

    /** @return array<int, string> */
    public function warnings(): array
    {
        return array_values(array_unique($this->warnings));
    }

    /** @return array<int, string> */
    public function images(): array
    {
        return $this->images;
    }

    /**
     * @param  array<string, mixed>  $block
     */
    private function block(array $block, int $depth): string
    {
        $type = $block['type'] ?? '';
        $data = $block[$type] ?? [];
        $text = fn () => $this->richText($data['rich_text'] ?? []);

        switch ($type) {
            case 'paragraph':
                $inner = $text();

                return ($inner === '' ? '' : "<p>{$inner}</p>").$this->children($block, $depth);

            case 'heading_1':
            case 'heading_2':
                return '<h2>'.$text().'</h2>'.$this->children($block, $depth);

            case 'heading_3':
                return '<h3>'.$text().'</h3>'.$this->children($block, $depth);

            case 'quote':
                return '<blockquote>'.$this->paragraphOrNothing($text()).$this->children($block, $depth).'</blockquote>';

            case 'callout':
                // Le texte d'une callout vit soit dans son rich_text, soit dans
                // des paragraphes enfants (saisie sur plusieurs lignes) : jamais de <p> vide.
                return '<blockquote>'.$this->paragraphOrNothing($text()).$this->children($block, $depth).'</blockquote>';

            case 'toggle':
                return '<h3>'.$text().'</h3>'.$this->children($block, $depth);

            case 'divider':
                return '<hr>';

            case 'code':
                $plain = implode('', array_map(fn ($t) => (string) ($t['plain_text'] ?? ''), $data['rich_text'] ?? []));

                return '<pre><code>'.$this->e($plain).'</code></pre>';

            case 'image':
                return $this->image($block);

            case 'table':
                return $this->table($block, $data);

            case 'bookmark':
            case 'embed':
            case 'link_preview':
                $url = $this->safeUrl((string) ($data['url'] ?? ''));

                return $url ? '<p><a href="'.$this->attr($url).'" rel="noopener">'.$this->e($url).'</a></p>' : '';

            case 'column_list':
            case 'column':
            case 'synced_block':
                return $this->children($block, $depth);

            default:
                $this->warnings[] = "bloc « {$type} » ignoré";

                return '';
        }
    }

    private function paragraphOrNothing(string $inner): string
    {
        return $inner === '' ? '' : "<p>{$inner}</p>";
    }

    /**
     * @param  array<string, mixed>  $block
     */
    private function listItem(array $block, int $depth): string
    {
        $type = $block['type'];
        $data = $block[$type] ?? [];
        $inner = $this->richText($data['rich_text'] ?? []);

        if ($type === 'to_do') {
            $inner = (($data['checked'] ?? false) ? '☑ ' : '☐ ').$inner;
        }

        return '<li>'.$inner.$this->children($block, $depth).'</li>';
    }

    /**
     * @param  array<string, mixed>  $block
     */
    private function children(array $block, int $depth): string
    {
        if (! ($block['has_children'] ?? false) || $depth >= 5) {
            return '';
        }

        $children = ($this->childrenFetcher)((string) $block['id']);
        if ($children === null) {
            $this->warnings[] = 'contenu imbriqué illisible';

            return '';
        }

        return $this->render($children, $depth + 1);
    }

    /**
     * @param  array<string, mixed>  $block
     */
    private function image(array $block): string
    {
        $data = $block['image'] ?? [];
        $src = ($this->imageResolver)($block);

        if (! $src) {
            $this->warnings[] = 'image non récupérée';

            return '';
        }

        $this->images[] = $src;
        $caption = $this->richText($data['caption'] ?? []);
        $alt = $this->attr(trim(strip_tags(html_entity_decode($caption, ENT_QUOTES | ENT_HTML5, 'UTF-8'))));

        return '<p><img src="'.$this->attr($src).'" alt="'.$alt.'"></p>'
            .($caption !== '' ? "<p><em>{$caption}</em></p>" : '');
    }

    /**
     * @param  array<string, mixed>  $block
     * @param  array<string, mixed>  $data
     */
    private function table(array $block, array $data): string
    {
        $rows = ($this->childrenFetcher)((string) $block['id']) ?? [];
        $hasHeader = (bool) ($data['has_column_header'] ?? false);
        $head = '';
        $body = '';

        foreach (array_values($rows) as $index => $row) {
            $cells = $row['table_row']['cells'] ?? [];
            $isHeader = $hasHeader && $index === 0;
            $tag = $isHeader ? 'th' : 'td';
            $line = '<tr>'.implode('', array_map(
                fn ($cell) => "<{$tag}>".$this->richText($cell)."</{$tag}>",
                $cells
            )).'</tr>';

            $isHeader ? $head .= $line : $body .= $line;
        }

        return '<table>'.($head !== '' ? "<thead>{$head}</thead>" : '')."<tbody>{$body}</tbody></table>";
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    public function richText(array $items): string
    {
        $out = '';

        foreach ($items as $item) {
            $piece = nl2br($this->e((string) ($item['plain_text'] ?? '')), false);
            if ($piece === '') {
                continue;
            }

            $a = $item['annotations'] ?? [];
            if ($a['code'] ?? false) {
                $piece = "<code>{$piece}</code>";
            }
            if ($a['bold'] ?? false) {
                $piece = "<strong>{$piece}</strong>";
            }
            if ($a['italic'] ?? false) {
                $piece = "<em>{$piece}</em>";
            }
            if ($a['strikethrough'] ?? false) {
                $piece = "<s>{$piece}</s>";
            }
            if ($a['underline'] ?? false) {
                $piece = "<u>{$piece}</u>";
            }

            $href = $this->safeUrl((string) ($item['href'] ?? ''));
            if ($href) {
                $rel = str_starts_with($href, '/') || str_starts_with($href, '#') ? '' : ' rel="noopener"';
                $piece = '<a href="'.$this->attr($href).'"'.$rel.'>'.$piece.'</a>';
            }

            $out .= $piece;
        }

        return $out;
    }

    /**
     * Garde les liens utiles au lecteur, retire les liens internes Notion
     * (pages de l'espace de travail, invisibles pour un visiteur du site).
     */
    private function safeUrl(string $url): ?string
    {
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        // Lien interne Notion : "/<32 hex>" ou domaine notion.so / notion.site / notion.com.
        if (preg_match('#^/[0-9a-f]{32}#i', $url)
            || preg_match('#^https?://([a-z0-9-]+\.)*(notion\.so|notion\.site|notion\.com)(/|$)#i', $url)) {
            return null;
        }

        if (str_starts_with($url, '/') || str_starts_with($url, '#')) {
            return $url;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https', 'mailto', 'tel'], true) ? $url : null;
    }

    /**
     * Échappement d'un nœud texte : les apostrophes et guillemets restent tels
     * quels (« l'habilitation », pas « l&apos;habilitation »), sinon ils
     * ressortiraient encodés dans le schéma FAQPage et le temps de lecture.
     */
    private function e(string $value): string
    {
        return htmlspecialchars($value, ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
    }

    private function attr(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
