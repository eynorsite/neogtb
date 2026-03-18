<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Catégories
        $categories = [
            ['name' => 'Guides', 'slug' => 'guides', 'color' => '#2563eb', 'order' => 1],
            ['name' => 'Réglementation', 'slug' => 'reglementation', 'color' => '#dc2626', 'order' => 2],
            ['name' => 'Technologies', 'slug' => 'technologies', 'color' => '#16a34a', 'order' => 3],
            ['name' => 'Tendances', 'slug' => 'tendances', 'color' => '#9333ea', 'order' => 4],
        ];

        foreach ($categories as $cat) {
            PostCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['is_active' => true])
            );
        }

        // Articles existants du site Astro
        $posts = [
            [
                'title' => 'Qu\'est-ce que la GTB ? Guide complet 2026',
                'slug' => 'guide-complet-gtb-2026',
                'excerpt' => 'Tout ce que vous devez savoir sur la Gestion Technique du Bâtiment en 2026.',
                'category_id' => PostCategory::where('slug', 'guides')->first()?->id,
                'status' => 'published',
                'published_at' => '2026-03-09',
            ],
            [
                'title' => 'GTB vs GTC : quelles différences ?',
                'slug' => 'gtb-vs-gtc-differences',
                'excerpt' => 'Comprendre les différences fondamentales entre la GTB et la GTC.',
                'category_id' => PostCategory::where('slug', 'guides')->first()?->id,
                'status' => 'published',
                'published_at' => '2026-03-09',
            ],
            [
                'title' => 'Le décret tertiaire et la GTB : obligations',
                'slug' => 'decret-tertiaire-gtb-obligations',
                'excerpt' => 'Comprendre les obligations du décret tertiaire liées à la GTB.',
                'category_id' => PostCategory::where('slug', 'reglementation')->first()?->id,
                'status' => 'published',
                'published_at' => '2026-03-09',
            ],
            [
                'title' => 'Les protocoles de communication : BACnet, KNX, Modbus',
                'slug' => 'protocoles-communication-bacnet-knx-modbus',
                'excerpt' => 'Guide des principaux protocoles utilisés en GTB/GTC.',
                'category_id' => PostCategory::where('slug', 'technologies')->first()?->id,
                'status' => 'published',
                'published_at' => '2026-03-09',
            ],
            [
                'title' => 'Smart Building : tendances 2026',
                'slug' => 'smart-building-tendances-2026',
                'excerpt' => 'Les grandes tendances du bâtiment intelligent en 2026.',
                'category_id' => PostCategory::where('slug', 'tendances')->first()?->id,
                'status' => 'published',
                'published_at' => '2026-03-09',
            ],
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'author_id' => 1,
                    'is_featured' => false,
                    'content' => '<p>Contenu à migrer depuis le fichier Markdown du site Astro.</p>',
                ])
            );
        }

        $this->command->info(count($posts) . ' articles de blog injectés.');
    }
}
