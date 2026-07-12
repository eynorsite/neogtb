<?php

namespace App\Console\Commands;

use App\Http\Controllers\SitemapController;
use App\Models\Post;
use App\Models\SitePage;
use App\Services\IndexNowService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class IndexNowSubmit extends Command
{
    protected $signature = 'indexnow:submit
        {--all : Soumet TOUTES les URLs publiques (source : sitemap) au lieu du seul contenu récent}
        {--since=2 : En mode incrémental, ne soumet que le contenu modifié depuis N jours}';

    protected $description = 'Soumet les URLs à jour à IndexNow (Bing/Copilot, Yandex…) pour indexation rapide.';

    public function handle(IndexNowService $indexNow): int
    {
        if (! $indexNow->isEnabled()) {
            $this->warn('IndexNow désactivé (hors production, ou INDEXNOW_ENABLED=false). Aucune URL envoyée.');

            return self::SUCCESS;
        }

        $urls = $this->option('all')
            ? $this->allUrlsFromSitemap()
            : $this->recentUrls((int) $this->option('since'));

        if (empty($urls)) {
            $this->info('Aucune URL à soumettre.');

            return self::SUCCESS;
        }

        $status = $indexNow->submit($urls);

        $this->info(sprintf(
            'IndexNow : %d URL(s) soumise(s) — réponse HTTP %s.',
            count($urls),
            $status ?? 'aucune (désactivé/échec)'
        ));

        // 200 = accepté, 202 = accepté (traitement différé) : les deux sont des succès.
        return in_array($status, [200, 202], true) || $status === null ? self::SUCCESS : self::FAILURE;
    }

    /**
     * Toutes les URLs publiques, en réutilisant le sitemap comme source de vérité unique.
     */
    protected function allUrlsFromSitemap(): array
    {
        $xml = app(SitemapController::class)->index()->getContent();
        preg_match_all('/<loc>([^<]+)<\/loc>/', (string) $xml, $matches);

        return array_map('htmlspecialchars_decode', $matches[1] ?? []);
    }

    /**
     * URLs du contenu modifié récemment (pages CMS + articles publiés).
     */
    protected function recentUrls(int $sinceDays): array
    {
        $base = rtrim((string) config('app.url'), '/');
        $since = Carbon::now()->subDays(max(1, $sinceDays));
        $urls = [];

        SitePage::query()
            ->where('is_published', true)
            ->where('updated_at', '>=', $since)
            ->get(['slug', 'updated_at'])
            ->each(function (SitePage $page) use (&$urls, $base) {
                if (blank($page->slug)) {
                    return;
                }
                $urls[] = $page->slug === 'accueil'
                    ? $base . '/'
                    : $base . '/' . ltrim($page->slug, '/');
            });

        Post::query()
            ->where('status', 'published')
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', Carbon::now()))
            ->where('updated_at', '>=', $since)
            ->get(['slug', 'updated_at'])
            ->each(function (Post $post) use (&$urls, $base) {
                if (filled($post->slug)) {
                    $urls[] = $base . '/blog/' . $post->slug;
                }
            });

        return $urls;
    }
}
