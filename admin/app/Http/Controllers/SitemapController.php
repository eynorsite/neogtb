<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SitePage;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * Generate the public sitemap.xml for NeoGTB.
     */
    public function index(): Response
    {
        $base = rtrim(config('app.url'), '/');

        // Static routes: [path, changefreq, priority]
        $staticRoutes = [
            ['/',                              'weekly',  '1.0'],
            ['/blog',                          'daily',   '0.9'],
            ['/about',                         'monthly', '0.6'],
            ['/faq',                           'monthly', '0.6'],
            ['/contact',                       'monthly', '0.7'],
            ['/reglementation',                'monthly', '0.8'],
            ['/decret-bacs',                   'monthly', '0.9'],
            ['/modele-cctp-decret-bacs',       'monthly', '0.8'],
            ['/amo-gtb-gtc',                   'monthly', '0.9'],
            ['/offres',                        'monthly', '0.8'],
            ['/offre-conformite-continue',     'monthly', '0.8'],
            ['/positionnement',                'monthly', '0.6'],
            ['/gtb',                           'monthly', '0.9'],
            ['/gtc',                           'monthly', '0.9'],
            ['/solutions',                     'monthly', '0.8'],
            ['/audit',                         'monthly', '0.9'],
            ['/comparateur',                   'monthly', '0.8'],
            ['/generateur-cee',                'monthly', '0.8'],
            ['/tables-modbus',                 'monthly', '0.7'],
            ['/comparatif/gtb-vs-gtc',                      'monthly', '0.8'],
            ['/comparatif/decret-bacs-vs-decret-tertiaire', 'monthly', '0.8'],
            ['/guide/protocoles-gtb',          'monthly', '0.8'],
            ['/guide/classes-en-15232',        'monthly', '0.8'],
            ['/guide/gtb-obligatoire-puissance', 'monthly', '0.8'],
            ['/mentions-legales',              'yearly',  '0.3'],
            ['/politique-de-confidentialite',  'yearly',  '0.3'],
            ['/mes-droits-rgpd',               'yearly',  '0.3'],
            ['/cookies',                       'yearly',  '0.3'],
        ];

        $urls = [];
        // Track les paths déjà ajoutés (statiques) pour dé-dupliquer la boucle SitePage,
        // qui peut contenir les mêmes slugs côté BDD (accueil, gtb, gtc, contact, etc.).
        $addedPaths = [];

        // Dates de dernière modification réelles, indexées par slug de SitePage.
        // Google déclare ignorer les <lastmod> qu'il juge non fiables : émettre
        // Carbon::now() sur toutes les pages statiques revenait à annoncer « modifiée
        // à l'instant » à chaque crawl, ce qui décrédibilise le sitemap entier.
        // Règle retenue : vraie date si on en connaît une, sinon PAS de <lastmod>.
        $pageDates = SitePage::query()
            ->where('is_published', true)
            ->whereNotNull('updated_at')
            ->pluck('updated_at', 'slug')
            ->map(fn ($d) => Carbon::parse($d)->toAtomString());

        // /blog est une liste : sa vraie date de fraîcheur est celle du dernier article publié.
        $lastPostAt = Post::query()
            ->where('status', 'published')
            ->max('published_at');

        foreach ($staticRoutes as [$path, $changefreq, $priority]) {
            $slug = $path === '/' ? 'accueil' : ltrim($path, '/');
            $lastmod = $pageDates[$slug] ?? null;
            if ($path === '/blog' && $lastPostAt) {
                $lastmod = Carbon::parse($lastPostAt)->toAtomString();
            }

            $urls[] = [
                'loc'        => $base . $path,
                'lastmod'    => $lastmod,
                'changefreq' => $changefreq,
                'priority'   => $priority,
            ];
            $addedPaths[$path] = true;
        }

        // Dynamic CMS pages
        SitePage::query()
            ->where('is_published', true)
            ->get(['slug', 'updated_at'])
            ->each(function (SitePage $page) use (&$urls, &$addedPaths, $base) {
                if (blank($page->slug)) {
                    return;
                }
                // Skip 'accueil' : déjà couvert par la route racine '/'
                if ($page->slug === 'accueil') {
                    return;
                }
                $path = '/' . ltrim($page->slug, '/');
                if (isset($addedPaths[$path])) {
                    return;
                }
                $urls[] = [
                    'loc'        => $base . $path,
                    'lastmod'    => optional($page->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
                $addedPaths[$path] = true;
            });

        // Blog posts
        Post::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', Carbon::now());
            })
            ->get(['slug', 'updated_at', 'published_at'])
            ->each(function (Post $post) use (&$urls, $base) {
                if (blank($post->slug)) {
                    return;
                }
                $lastmod = $post->updated_at ?: $post->published_at;
                $urls[] = [
                    'loc'        => $base . '/blog/' . $post->slug,
                    'lastmod'    => $lastmod?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.8',
                ];
            });

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
            // <lastmod> omis (et non vide) quand aucune date fiable n'est connue :
            // le schéma sitemaps.org impose un W3C datetime, une balise vide invalide l'entrée.
            if (filled($u['lastmod'])) {
                $xml .= '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
            }
            $xml .= '    <changefreq>' . $u['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>' . "\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
