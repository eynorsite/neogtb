<?php

namespace App\Observers;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class PageSyncObserver
{
    public function saved(SitePage $page): void
    {
        $this->sync('page saved: ' . $page->slug);
    }

    public function deleted(SitePage $page): void
    {
        $this->sync('page deleted: ' . $page->slug);
    }

    private function sync(string $event): void
    {
        try {
            Artisan::call('sync:pages', ['--rebuild' => true]);
            Log::info("Pages sync + rebuild déclenché ({$event})");
        } catch (\Throwable $e) {
            Log::error("Erreur sync pages ({$event}): {$e->getMessage()}");
        }
    }
}
