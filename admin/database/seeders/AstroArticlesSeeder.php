<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use Symfony\Component\Yaml\Yaml;

class AstroArticlesSeeder extends Seeder
{
    /**
     * Import all 20 Astro blog articles into the Laravel database.
     *
     * Idempotent: uses firstOrCreate on slug, so safe to run multiple times.
     */
    public function run(): void
    {
        $astroPath = base_path('../src/content/blog');

        if (! is_dir($astroPath)) {
            $this->command->error("Astro blog directory not found: {$astroPath}");
            return;
        }

        // ── Markdown converter with table support ──
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension());
        $environment->addExtension(new TableExtension());
        $converter = new MarkdownConverter($environment);

        // ── Category color mapping ──
        $categoryColors = [
            'Guide'          => '#2563eb',
            'Réglementation' => '#dc2626',
            'Tendances'      => '#9333ea',
        ];

        // ── Scan all .md files ──
        $files = glob("{$astroPath}/*.md");

        if (empty($files)) {
            $this->command->warn('No .md files found in Astro blog directory.');
            return;
        }

        $imported = 0;
        $skipped  = 0;

        foreach ($files as $file) {
            $raw = file_get_contents($file);

            // Parse frontmatter (between ---  --- delimiters)
            if (! preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)/s', $raw, $matches)) {
                $this->command->warn("Skipping {$file}: no valid frontmatter found.");
                $skipped++;
                continue;
            }

            $frontmatter = Yaml::parse($matches[1]);
            $markdownBody = trim($matches[2]);

            // ── Required fields ──
            $title       = $frontmatter['title'] ?? null;
            $description = $frontmatter['description'] ?? null;
            $date        = $frontmatter['date'] ?? null;
            $author      = $frontmatter['author'] ?? 'NeoGTB';
            $category    = $frontmatter['category'] ?? null;
            $tags        = $frontmatter['tags'] ?? [];
            $featured    = $frontmatter['featured'] ?? false;
            $image       = $frontmatter['image'] ?? null;

            if (! $title) {
                $this->command->warn("Skipping {$file}: missing title.");
                $skipped++;
                continue;
            }

            // ── Slug from filename ──
            $slug = pathinfo($file, PATHINFO_FILENAME);

            // ── Category (create if needed) ──
            $categoryModel = null;
            if ($category) {
                $catSlug = Str::slug($category);
                $categoryModel = PostCategory::firstOrCreate(
                    ['slug' => $catSlug],
                    [
                        'name'      => $category,
                        'color'     => $categoryColors[$category] ?? null,
                        'order'     => match ($category) {
                            'Guide'          => 1,
                            'Réglementation' => 2,
                            'Tendances'      => 3,
                            default          => 10,
                        },
                        'is_active' => true,
                    ]
                );
            }

            // ── Tags (create if needed) ──
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tagSlug = Str::slug($tagName);
                $tag = PostTag::firstOrCreate(
                    ['slug' => $tagSlug],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }

            // ── Convert Markdown to HTML ──
            $htmlContent = $converter->convert($markdownBody)->getContent();

            // ── Create post (idempotent on slug) ──
            $post = Post::firstOrCreate(
                ['slug' => $slug],
                [
                    'title'            => $title,
                    'excerpt'          => $description,
                    'content'          => $htmlContent,
                    'featured_image'   => $image,
                    'author_id'        => 1, // SuperAdmin
                    'category_id'      => $categoryModel?->id,
                    'status'           => 'published',
                    'published_at'     => $date ? \Carbon\Carbon::parse($date) : now(),
                    'meta_title'       => $title . ' | NeoGTB',
                    'meta_description' => $description,
                    'is_featured'      => (bool) $featured,
                ]
            );

            // ── Sync tags (only if just created to remain idempotent) ──
            if ($post->wasRecentlyCreated && ! empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            if ($post->wasRecentlyCreated) {
                $imported++;
            } else {
                $skipped++;
            }
        }

        $this->command->info("{$imported} articles imported, {$skipped} skipped (already exist).");
    }
}
