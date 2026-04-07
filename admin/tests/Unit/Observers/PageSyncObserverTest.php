<?php

namespace Tests\Unit\Observers;

use App\Jobs\SyncPagesJob;
use Database\Factories\SitePageFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PageSyncObserverTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_dispatches_sync_pages_job_on_page_save(): void
    {
        Bus::fake();
        Cache::forget('sync_pages_debounce');

        SitePageFactory::new()->create();

        Bus::assertDispatched(SyncPagesJob::class);
    }

    #[Test]
    public function it_debounces_multiple_dispatches(): void
    {
        Bus::fake();
        Cache::forget('sync_pages_debounce');

        SitePageFactory::new()->count(3)->create();

        Bus::assertDispatchedTimes(SyncPagesJob::class, 1);
    }
}
