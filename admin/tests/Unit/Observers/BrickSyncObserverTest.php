<?php

namespace Tests\Unit\Observers;

use App\Jobs\SyncPagesJob;
use Database\Factories\PageBrickFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BrickSyncObserverTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_dispatches_sync_pages_job_on_brick_save(): void
    {
        Bus::fake();
        Cache::forget('sync_pages_debounce');

        PageBrickFactory::new()->create();

        Bus::assertDispatched(SyncPagesJob::class);
    }

    #[Test]
    public function it_debounces_multiple_dispatches(): void
    {
        Bus::fake();
        Cache::forget('sync_pages_debounce');

        PageBrickFactory::new()->count(3)->create();

        // Note: SitePage creation also triggers SyncPagesJob via PageSyncObserver,
        // mais le debounce partagé sur 'sync_pages_debounce' garantit 1 seul dispatch.
        Bus::assertDispatchedTimes(SyncPagesJob::class, 1);
    }
}
