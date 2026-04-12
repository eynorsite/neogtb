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
        $now = Carbon::now()->toAtomString();
        $base = rtrim(config('app.url'), '/');

        // Static routes: [path, changefreq, priority]
        $staticRoutes = [
            ['/',                              'weekly',  '1.0'],
            ['/blog',                          'daily',   '0.9'],
            ['/about',                         'monthly', '0.6'],
            ['/faq',                           'monthly', '0.6'],
            ['/contact',                       'monthly', '0.7'],
            ['/reglementation',                'monthly', '0.8'],
            ['/positionnement',                'monthly', '0.6'],
            ['/gtb',                           'monthly', '0.9'],
            ['/gtc',                           'monthly', '0.9'],
            ['/solutions',                     'monthly', '0.8'],
            ['/audit',                         'monthly', '0.9'],
            ['/comparateur',                   'monthly', '0.8'],
            ['/generateur-cee',                'monthly', '0.8'],
            ['/tables-modbus',                 'monthly', '0.7'],
            ['/mentions-legales',              'yearly',  '0.3'],
            ['/politique-de-confidentialite',  'yearly',  '0.3'],
            ['/mes-droits-rgpd',               'yearly',  '0.3'],
            ['/cookies',                       'yearly',  '0.3'],
        ];

        $urls = [];

        foreach ($staticRoutes as [$path, $changefreq, $priority]) {
            $urls[] = [
                'loc'        => $base . $path,
                'lastmod'    => $now,
                'changefreq' => $changefreq,
                'priority'   => $priority,
            ];
        }

        // Dynamic CMS pages
        SitePage::query()
            ->where('is_published', true)
            ->get(['slug', 'updated_at'])
            ->each(function (SitePage $page) use (&$urls, $base, $now) {
                if (blank($page->slug)) {
                    return;
                }
                $urls[] = [
                    'loc'        => $base . '/' . ltrim($page->slug, '/'),
                    'lastmod'    => optional($page->updated_at)->toAtomString() ?: $now,
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            });

        // Blog posts
        Post::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', Carbon::now());
            })
            ->get(['slug', 'updated_at', 'published_at'])
            ->each(function (Post $post) use (&$urls, $base, $now) {
                if (blank($post->slug)) {
                    return;
                }
                $lastmod = $post->updated_at ?: $post->published_at;
                $urls[] = [
                    'loc'        => $base . '/blog/' . $post->slug,
                    'lastmod'    => $lastmod ? $lastmod->toAtomString() : $now,
                    'changefreq' => 'monthly',
                    'priority'   => '0.8',
                ];
            });

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
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
