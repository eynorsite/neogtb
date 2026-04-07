<?php

namespace Tests\Unit\Observers;

use App\Jobs\SyncBlogJob;
use App\Models\Admin;
use App\Models\Post;
use Database\Factories\PostFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostSyncObserverTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_dispatches_sync_blog_job_on_post_save(): void
    {
        Bus::fake();
        Cache::forget('sync_blog_debounce');

        $admin = Admin::factory()->create();
        PostFactory::new()->create(['author_id' => $admin->id]);

        Bus::assertDispatched(SyncBlogJob::class);
    }

    #[Test]
    public function it_debounces_multiple_dispatches(): void
    {
        Bus::fake();
        Cache::forget('sync_blog_debounce');

        $admin = Admin::factory()->create();
        PostFactory::new()->count(3)->create(['author_id' => $admin->id]);

        Bus::assertDispatchedTimes(SyncBlogJob::class, 1);
    }
}
