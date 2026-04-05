<?php

namespace App\Console\Commands;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class SyncPagesCommand extends Command
{
    protected $signature = 'sync:pages {--rebuild : Lancer le build Astro après la sync}';
    protected $description = 'Exporte les pages et bricks vers JSON pour Astro';

    private string $dataDir;

    public function __construct()
    {
        parent::__construct();
        $this->dataDir = config('neogtb.astro_src_path', '/var/www/neogtb-src') . '/src/data';
    }

    public function handle(): int
    {
        if (!is_dir($this->dataDir)) {
            mkdir($this->dataDir, 0775, true);
        }

        $pages = SitePage::with(['bricks' => fn ($q) => $q->where('is_visible', true)->orderBy('order')])
            ->where('is_published', true)
            ->orderBy('order')
            ->get();

        $pagesData = [];

        foreach ($pages as $page) {
            $pageData = [
                'slug' => $page->slug,
                'name' => $page->name,
                'hero' => [
                    'title' => $page->hero_title,
                    'subtitle' => $page->hero_subtitle,
                    'description' => $page->hero_description,
                    'cta_text' => $page->hero_cta_text,
                    'cta_url' => $page->hero_cta_url,
                    'image' => $page->hero_image,
                ],
                'seo' => [
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'meta_keywords' => $page->meta_keywords,
                    'og_title' => $page->og_title,
                    'og_description' => $page->og_description,
                    'og_image' => $page->og_image,
                ],
                'bricks' => $page->bricks->map(fn (PageBrick $b) => [
                    'type' => $b->brick_type,
                    'name' => $b->brick_name,
                    'content' => $b->content ?? [],
                    'settings' => $b->settings ?? [],
                ])->toArray(),
            ];

            $pagesData[$page->slug] = $pageData;
        }

        $jsonPath = $this->dataDir . '/pages.json';
        $newJson = json_encode($pagesData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $existingJson = file_exists($jsonPath) ? file_get_contents($jsonPath) : null;

        if ($existingJson === $newJson) {
            $this->info('Rien à synchroniser — pages à jour.');

            if ($this->option('rebuild')) {
                $this->rebuild();
            }

            return self::SUCCESS;
        }

        file_put_contents($jsonPath, $newJson);
        $this->info('✓ ' . count($pagesData) . ' page(s) exportée(s) vers pages.json');

        if ($this->option('rebuild')) {
            $this->rebuild();
        }

        return self::SUCCESS;
    }

    private function rebuild(): void
    {
        $deployScript = config('neogtb.astro_src_path', '/var/www/neogtb-src') . '/deploy.sh';

        $this->info('Rebuild Astro en cours...');
        $process = Process::timeout(180)->run("sudo /bin/bash {$deployScript}");

        if ($process->successful()) {
            $this->info('✓ Build et déploiement terminés.');
        } else {
            $this->error('✗ Erreur build Astro :');
            $this->line($process->errorOutput());
        }
    }
}
