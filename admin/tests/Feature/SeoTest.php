<?php

namespace Tests\Feature;

use App\Models\SitePage;
use Database\Factories\PostFactory;
use Database\Factories\SitePageFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Couvre l'infrastructure SEO / GEO de NeoGTB :
 * meta & schémas JSON-LD (Organization + knowsAbout, Article, FAQPage),
 * sitemap.xml dynamique, robots.txt (groupes bots IA), llms.txt.
 */
class SeoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * La home (StaticPageController::accueil) lit un SitePage de slug 'accueil'
     * via firstOrFail() puis rend la vue front.page. On le crée pour chaque test
     * qui touche '/'.
     */
    private function makeHomePage(): SitePage
    {
        return SitePageFactory::new()->create([
            'slug' => 'accueil',
            'name' => 'Accueil',
            'is_published' => true,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Meta & schémas
    // ─────────────────────────────────────────────────────────────────────────

    #[Test]
    public function home_returns_200_with_title_and_meta_description(): void
    {
        $this->makeHomePage();

        $response = $this->get('/');
        $response->assertOk();

        $html = $response->getContent();
        $this->assertStringContainsString('<title>', $html);
        $this->assertMatchesRegularExpression('/<title>.+<\/title>/s', $html);
        $this->assertStringContainsString('<meta name="description"', $html);
    }

    #[Test]
    public function home_contains_organization_json_ld_with_knows_about(): void
    {
        $this->makeHomePage();

        $response = $this->get('/');
        $response->assertOk();

        $html = $response->getContent();
        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('"@type": "Organization"', $html);
        // knowsAbout ajouté pour le signal d'entité GEO.
        $this->assertStringContainsString('knowsAbout', $html);
    }

    #[Test]
    public function published_article_page_exposes_article_schema(): void
    {
        $post = PostFactory::new()->create([
            'title' => 'Guide complet de la GTB en 2026',
            'excerpt' => 'Tout savoir sur la Gestion Technique du Bâtiment.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/blog/' . $post->slug);
        $response->assertOk();

        $html = $response->getContent();

        // Titre de l'article et meta description présents.
        $this->assertStringContainsString($post->title, $html);
        $this->assertStringContainsString('<meta name="description"', $html);

        // JSON-LD Article avec wordCount (contenu non vide) et inLanguage.
        $this->assertStringContainsString('"@type":"Article"', $html);
        $this->assertStringContainsString('wordCount', $html);
        $this->assertStringContainsString('inLanguage', $html);
    }

    #[Test]
    public function faq_page_contains_faqpage_schema(): void
    {
        $response = $this->get('/faq');
        $response->assertOk();

        $html = $response->getContent();
        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('"@type": "FAQPage"', $html);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Sitemap
    // ─────────────────────────────────────────────────────────────────────────

    #[Test]
    public function sitemap_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = $response->getContent();
        $this->assertStringContainsString('<?xml', $xml);
        $this->assertStringContainsString('<urlset', $xml);
    }

    #[Test]
    public function sitemap_contains_published_post_slug(): void
    {
        $post = PostFactory::new()->create([
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/sitemap.xml');
        $response->assertOk();

        $xml = $response->getContent();
        $this->assertStringContainsString('/blog/' . $post->slug, $xml);
    }

    /**
     * Le sitemap émettait Carbon::now() comme <lastmod> des 28 routes statiques :
     * chaque crawl voyait « modifiée à l'instant », ce que Google traite comme un
     * signal non fiable. Une date inconnue doit désormais produire l'ABSENCE de
     * balise, jamais une balise vide (invalide au regard du schéma sitemaps.org).
     */
    #[Test]
    public function sitemap_never_emits_empty_or_generated_lastmod(): void
    {
        $editedAt = now()->subMonths(3)->startOfMinute();
        $this->makeHomePage()->forceFill(['updated_at' => $editedAt])->saveQuietly();

        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

        // Une balise vide serait invalide au regard du schéma sitemaps.org.
        $this->assertStringNotContainsString('<lastmod></lastmod>', $xml);

        preg_match_all('#<lastmod>(.*?)</lastmod>#', $xml, $matches);
        $this->assertNotEmpty($matches[1], 'Aucun lastmod émis alors que des dates réelles existent.');

        foreach ($matches[1] as $lastmod) {
            // Aucune date ne doit être l'instant du rendu : c'était le défaut corrigé
            // (Carbon::now() servi comme lastmod des 28 routes statiques).
            $this->assertGreaterThan(
                5,
                abs(now()->diffInSeconds(\Illuminate\Support\Carbon::parse($lastmod))),
                "Le lastmod {$lastmod} correspond à l'heure de génération du sitemap."
            );
        }

        // La racine porte bien la date d'édition réelle de la page « accueil ».
        $this->assertStringContainsString($editedAt->toAtomString(), $xml);
    }

    /**
     * Consulter un article incrémente son compteur de vues. Tant que cet incrément
     * passait par Eloquent, il touchait aussi updated_at : le <lastmod> de chaque
     * article bougeait à chaque VISITE, et le sitemap annonçait « modifié » sans
     * qu'aucun contenu n'ait changé. La visite ne doit rien changer d'autre que
     * le compteur.
     */
    #[Test]
    public function viewing_an_article_does_not_change_its_last_modified_date(): void
    {
        $post = PostFactory::new()->create([
            'status' => 'published',
            'published_at' => now()->subMonth(),
        ]);

        $post->forceFill(['updated_at' => now()->subMonth()])->saveQuietly();
        $before = $post->fresh()->updated_at;
        $viewsBefore = (int) $post->fresh()->views_count;

        $this->get('/blog/' . $post->slug)->assertOk();

        $after = $post->fresh();
        $this->assertSame($viewsBefore + 1, (int) $after->views_count, 'Le compteur de vues doit être incrémenté.');
        $this->assertSame(
            $before->toAtomString(),
            $after->updated_at->toAtomString(),
            "Une simple visite a modifié updated_at, donc le <lastmod> du sitemap."
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Fil d'Ariane structuré
    // ─────────────────────────────────────────────────────────────────────────

    /** Extrait le premier nœud JSON-LD du type demandé dans une page. */
    private function jsonLdNode(string $html, string $type): ?array
    {
        preg_match_all('#<script type="application/ld\+json"[^>]*>(.*?)</script>#s', $html, $blocks);

        foreach ($blocks[1] as $block) {
            $decoded = json_decode(trim($block), true);
            if (! is_array($decoded)) {
                continue;
            }
            $nodes = $decoded['@graph'] ?? [$decoded];
            foreach ($nodes as $node) {
                if (($node['@type'] ?? null) === $type) {
                    return $node;
                }
            }
        }

        return null;
    }

    #[Test]
    public function article_breadcrumb_has_three_levels_without_brand_suffix(): void
    {
        $post = PostFactory::new()->create([
            'title' => 'Décret BACS en pratique',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $html = $this->get('/blog/' . $post->slug)->assertOk()->getContent();
        $breadcrumb = $this->jsonLdNode($html, 'BreadcrumbList');

        $this->assertNotNull($breadcrumb, 'Aucun BreadcrumbList sur la page article.');

        $names = array_column($breadcrumb['itemListElement'], 'name');
        $this->assertSame(['Accueil', 'Perspectives', 'Décret BACS en pratique'], $names);

        $positions = array_column($breadcrumb['itemListElement'], 'position');
        $this->assertSame([1, 2, 3], $positions);
    }

    #[Test]
    public function home_emits_no_breadcrumb_list(): void
    {
        $this->makeHomePage();

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertNull(
            $this->jsonLdNode($html, 'BreadcrumbList'),
            "L'accueil ne doit pas porter de fil d'Ariane (il en était la racine)."
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Entité de marque
    // ─────────────────────────────────────────────────────────────────────────

    #[Test]
    public function organization_and_website_share_a_linked_graph(): void
    {
        $this->makeHomePage();
        Cache::forget('site_json_ld');

        $html = $this->get('/')->assertOk()->getContent();

        $organization = $this->jsonLdNode($html, 'Organization');
        $website = $this->jsonLdNode($html, 'WebSite');

        $this->assertNotNull($organization, 'Nœud Organization absent.');
        $this->assertNotNull($website, 'Nœud WebSite absent.');

        // Le site écrit « NeoGTB » et « NéoGTB » selon les endroits : les deux graphies
        // doivent désigner une seule entité, sans quoi elles se concurrencent.
        $this->assertArrayHasKey('alternateName', $organization);
        $this->assertSame($organization['@id'], $website['publisher']['@id']);
        $this->assertSame('fr-FR', $website['inLanguage']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // robots.txt — fichier statique (servi par le serveur web, hors Laravel).
    // On asserte directement sur public_path('robots.txt'), seule source fiable
    // en environnement de test.
    // ─────────────────────────────────────────────────────────────────────────

    #[Test]
    public function robots_txt_declares_sitemap(): void
    {
        $robots = $this->robotsContent();

        $this->assertStringContainsString('Sitemap:', $robots);
        $this->assertStringContainsString('sitemap.xml', $robots);
    }

    #[Test]
    public function robots_txt_declares_ai_bot_groups(): void
    {
        $robots = $this->robotsContent();

        foreach ([
            'User-agent: GPTBot',
            'User-agent: PerplexityBot',
            'User-agent: Google-Extended',
            'User-agent: ClaudeBot',
            'User-agent: OAI-SearchBot',
        ] as $agent) {
            $this->assertStringContainsString($agent, $robots, "Groupe bot IA manquant : {$agent}");
        }
    }

    #[Test]
    public function gptbot_group_repeats_the_same_disallow_rules_as_star(): void
    {
        $robots = $this->robotsContent();

        // Extrait la section qui suit "User-agent: GPTBot" jusqu'au prochain
        // "User-agent:" (ou la fin du fichier).
        $section = $this->extractUserAgentSection($robots, 'GPTBot');
        $this->assertNotSame('', $section, 'Section GPTBot introuvable dans robots.txt');

        // Un groupe spécifique n'hérite PAS du groupe * : les Disallow doivent
        // être ré-émis à l'identique.
        $this->assertStringContainsString('Disallow: /admin', $section);
        $this->assertStringContainsString('Disallow: /rgpd/', $section);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // llms.txt — route dynamique (front.llms), cachée 1h.
    // ─────────────────────────────────────────────────────────────────────────

    #[Test]
    public function llms_txt_returns_plain_text_with_expected_headings(): void
    {
        Cache::forget('llms_txt');

        $response = $this->get('/llms.txt');
        $response->assertOk();
        $this->assertStringContainsString('text/plain', $response->headers->get('Content-Type'));

        $body = $response->getContent();
        $this->assertStringContainsString('# NeoGTB', $body);
        $this->assertStringContainsString('## Pages principales', $body);
    }

    #[Test]
    public function llms_txt_lists_published_articles(): void
    {
        // Le contenu est mis en cache : on vide avant ET on s'assure que le post
        // existe avant la première génération.
        Cache::forget('llms_txt');

        $post = PostFactory::new()->create([
            'title' => 'Article GEO de test NeoGTB',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Cache::forget('llms_txt');

        $response = $this->get('/llms.txt');
        $response->assertOk();

        $body = $response->getContent();
        // Le titre OU le slug de l'article publié doit apparaître.
        $this->assertTrue(
            Str::contains($body, $post->title) || Str::contains($body, $post->slug),
            'llms.txt ne référence ni le titre ni le slug de l\'article publié.'
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function robotsContent(): string
    {
        $path = public_path('robots.txt');
        $this->assertFileExists($path, 'public/robots.txt introuvable');

        return (string) file_get_contents($path);
    }

    private function extractUserAgentSection(string $robots, string $agent): string
    {
        $lines = preg_split('/\R/', $robots);
        $capturing = false;
        $section = [];

        foreach ($lines as $line) {
            if (preg_match('/^\s*User-agent:\s*(.+?)\s*$/i', $line, $m)) {
                if ($capturing) {
                    // Nouveau groupe rencontré -> fin de la section ciblée.
                    break;
                }
                if (strcasecmp(trim($m[1]), $agent) === 0) {
                    $capturing = true;
                    continue;
                }
            }
            if ($capturing) {
                $section[] = $line;
            }
        }

        return trim(implode("\n", $section));
    }
}
