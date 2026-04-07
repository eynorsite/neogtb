<?php

namespace App\Observers;

use App\Models\PageBrick;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BrickSyncObserver
{
    public function saved(PageBrick $brick): void
    {
        $this->sync('brick saved: ' . $brick->brick_name);
    }

    public function deleted(PageBrick $brick): void
    {
        $this->sync('brick deleted: ' . $brick->brick_name);
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
