<?php

namespace App\Observers;

use App\Models\PageBrick;
use Illuminate\Support\Facades\Artisan;
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
            Artisan::call('sync:pages', ['--rebuild' => true]);
            Log::info("Pages sync + rebuild déclenché ({$event})");
        } catch (\Throwable $e) {
            Log::error("Erreur sync pages ({$event}): {$e->getMessage()}");
        }
    }
}
