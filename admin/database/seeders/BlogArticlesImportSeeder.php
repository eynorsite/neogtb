<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;
use Symfony\Component\Yaml\Yaml;

/**
 * Importe les articles markdown Astro (src/content/blog/*.md)
 * vers la table Laravel `posts`.
 *
 * Utilise updateOrCreate sur le slug -> idempotent et met à jour
 * le contenu si l'article Astro a été modifié.
 *
 * Lancement :
 *   php artisan db:seed --class=BlogArticlesImportSeeder
 */
class BlogArticlesImportSeeder extends Seeder
{
    public function run(): void
    {
        // Source primaire : dossier versionné dans le repo
        $blogPath = database_path('seed-data/blog');

        // Fallback historique : dossier Astro (cas dev local pré-migration)
        if (! is_dir($blogPath)) {
            $blogPath = base_path('../src/content/blog');
        }

        if (! is_dir($blogPath)) {
            $this->command->error("Répertoire blog introuvable : {$blogPath}");
            return;
        }

        $astroPath = $blogPath;

        // Convertisseur Markdown -> HTML (avec support tables)
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new TableExtension());
        $converter = new MarkdownConverter($environment);

        // Couleurs par catégorie
        $categoryColors = [
            'Guide'          => '#2563eb',
            'Réglementation' => '#dc2626',
            'Tendances'      => '#9333ea',
        ];

        $files = glob("{$astroPath}/*.md");

        if (empty($files)) {
            $this->command->warn('Aucun fichier .md trouvé.');
            return;
        }

        $imported = 0;
        $updated  = 0;
        $skipped  = 0;

        foreach ($files as $file) {
            $raw = file_get_contents($file);

            if (! preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)/s', $raw, $matches)) {
                $this->command->warn("Skip {$file} : frontmatter invalide.");
                $skipped++;
                continue;
            }

            try {
                $frontmatter = Yaml::parse($matches[1]);
            } catch (\Throwable $e) {
                $this->command->warn("Skip {$file} : YAML invalide ({$e->getMessage()}).");
                $skipped++;
                continue;
            }

            $markdownBody = trim($matches[2]);

            $title       = $frontmatter['title'] ?? null;
            $description = $frontmatter['description'] ?? null;
            $date        = $frontmatter['date'] ?? ($frontmatter['pubDate'] ?? null);
            $category    = $frontmatter['category'] ?? null;
            $tags        = $frontmatter['tags'] ?? [];
            $featured    = $frontmatter['featured'] ?? false;
            $image       = $frontmatter['image'] ?? null;

            if (! $title) {
                $this->command->warn("Skip {$file} : title manquant.");
                $skipped++;
                continue;
            }

            $slug = pathinfo($file, PATHINFO_FILENAME);

            // Catégorie
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

            // Tags
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tagSlug = Str::slug($tagName);
                $tag = PostTag::firstOrCreate(
                    ['slug' => $tagSlug],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }

            // Markdown -> HTML
            $htmlContent = $converter->convert($markdownBody)->getContent();

            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'            => $title,
                    'excerpt'          => $description,
                    'content'          => $htmlContent,
                    'featured_image'   => $image,
                    'author_id'        => 1,
                    'category_id'      => $categoryModel?->id,
                    'status'           => 'published',
                    'published_at'     => $date ? \Carbon\Carbon::parse($date) : now(),
                    'meta_title'       => $title . ' | NeoGTB',
                    'meta_description' => $description,
                    'is_featured'      => (bool) $featured,
                ]
            );

            if (! empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            if ($post->wasRecentlyCreated) {
                $imported++;
            } else {
                $updated++;
            }
        }

        $this->command->info("Import terminé : {$imported} créés, {$updated} mis à jour, {$skipped} ignorés.");
    }
}
