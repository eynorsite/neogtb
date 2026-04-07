<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SyncPagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300;
    public int $backoff = 30;

    public function handle(): void
    {
        try {
            Artisan::call('sync:pages', ['--rebuild' => true]);
            Log::info('SyncPagesJob: terminé avec succès');
        } catch (\Throwable $e) {
            Log::error('SyncPagesJob échec: ' . $e->getMessage());
            throw $e;
        }
    }
}
