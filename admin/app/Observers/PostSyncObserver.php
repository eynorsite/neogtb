<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Artisan;
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
            Artisan::call('sync:blog');
            Log::info("Blog sync déclenché ({$event}): {$post->slug}");
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
