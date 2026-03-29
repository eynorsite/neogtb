<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use League\HTMLToMarkdown\HtmlConverter;

class SyncBlogCommand extends Command
{
    protected $signature = 'sync:blog {--rebuild : Lancer le build Astro après la sync}';
    protected $description = 'Synchronise les articles publiés vers les fichiers Markdown Astro';

    private string $blogDir;

    public function __construct()
    {
        parent::__construct();
        $this->blogDir = base_path('../src/content/blog');
    }

    public function handle(): int
    {
        $converter = new HtmlConverter([
            'strip_tags' => true,
            'hard_break' => true,
        ]);

        $posts = Post::with(['category', 'tags'])
            ->where('status', 'published')
            ->get();

        $synced = 0;

        foreach ($posts as $post) {
            $markdown = $this->buildMarkdown($post, $converter);
            $filePath = $this->blogDir . '/' . $post->slug . '.md';

            $existingContent = file_exists($filePath) ? file_get_contents($filePath) : null;

            if ($existingContent !== $markdown) {
                file_put_contents($filePath, $markdown);
                $this->info("✓ Sync: {$post->slug}.md");
                $synced++;
            }
        }

        if ($synced === 0) {
            $this->info('Rien à synchroniser — tout est à jour.');
        } else {
            $this->info("{$synced} article(s) synchronisé(s).");
        }

        if ($this->option('rebuild') && $synced > 0) {
            $this->info('Rebuild Astro en cours...');
            $projectRoot = realpath(base_path('..'));
            $process = Process::path($projectRoot)->timeout(120)->run('npm run build');

            if ($process->successful()) {
                $this->info('✓ Build Astro terminé.');
            } else {
                $this->error('✗ Erreur build Astro :');
                $this->line($process->errorOutput());
                return self::FAILURE;
            }
        }

        return self::SUCCESS;
    }

    private function buildMarkdown(Post $post, HtmlConverter $converter): string
    {
        $date = $post->published_at
            ? $post->published_at->format('Y-m-d')
            : $post->created_at->format('Y-m-d');

        $category = $post->category?->name ?? 'Général';

        $tags = $post->tags->pluck('name')->toArray();
        $tagsYaml = !empty($tags)
            ? '[' . implode(', ', array_map(fn($t) => '"' . $t . '"', $tags)) . ']'
            : '[]';

        $featured = $post->is_featured ? 'true' : 'false';

        $image = $post->featured_image
            ? "\nimage: \"/images/blog/{$post->featured_image}\""
            : '';

        $content = $post->content
            ? $converter->convert($post->content)
            : '';

        return <<<MD
---
title: "{$this->escapeYaml($post->title)}"
description: "{$this->escapeYaml($post->excerpt ?? '')}"
date: "{$date}"
author: "NeoGTB"
category: "{$this->escapeYaml($category)}"
tags: {$tagsYaml}
featured: {$featured}{$image}
---

{$content}
MD;
    }

    private function escapeYaml(string $value): string
    {
        $value = str_replace(["\r\n", "\r", "\n"], ' ', $value);
        $value = str_replace(['\\', '"'], ['\\\\', '\\"'], $value);
        return $value;
    }
}
