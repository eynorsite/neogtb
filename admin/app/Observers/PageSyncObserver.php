<?php

namespace App\Observers;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Support\Facades\Cache;
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
            $key = 'sync_pages_debounce';
            if (!Cache::has($key)) {
                Cache::put($key, true, 30);
                \App\Jobs\SyncPagesJob::dispatch()->delay(now()->addSeconds(15));
            }
            Log::info("Pages sync + rebuild déclenché ({$event})");
        } catch (\Throwable $e) {
            Log::error("Erreur sync pages ({$event}): {$e->getMessage()}");
        }
    }
}
