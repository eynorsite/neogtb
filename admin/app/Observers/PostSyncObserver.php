<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PostSyncObserver
{
    public function saved(Post $post): void
    {
        $this->sync($post, 'saved');
    }

    public function deleted(Post $post): void
    {
        $this->removeMarkdown($post);
        $this->sync($post, 'deleted');
    }

    private function sync(Post $post, string $event): void
    {
        try {
            $key = 'sync_blog_debounce';
            if (!Cache::has($key)) {
                Cache::put($key, true, 30);
                \App\Jobs\SyncBlogJob::dispatch()->delay(now()->addSeconds(15));
            }
            Log::info("Blog sync + rebuild déclenché ({$event}): {$post->slug}");
        } catch (\Throwable $e) {
            Log::error("Erreur sync blog ({$event}): {$e->getMessage()}");
        }
    }

    private function removeMarkdown(Post $post): void
    {
        $file = base_path("../src/content/blog/{$post->slug}.md");

        if (file_exists($file)) {
            unlink($file);
            Log::info("Fichier supprimé: {$post->slug}.md");
        }
    }
}
