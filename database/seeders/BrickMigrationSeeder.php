<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

class BrickMigrationSeeder extends Seeder
{
    public function run(): void
    {
        $pages = SitePage::all();

        foreach ($pages as $page) {
            // Skip if already has bricks
            if ($page->bricks()->count() > 0) {
                $this->command->info("Page '{$page->name}' already has bricks, skipping.");
                continue;
            }

            $order = 0;

            // Create Hero brick from existing hero fields
            if (filled($page->hero_title) || filled($page->hero_subtitle)) {
                PageBrick::create([
                    'page_id' => $page->id,
                    'brick_type' => 'hero',
                    'brick_name' => 'Hero',
                    'content' => [
                        'titre' => $page->hero_title ?? '',
                        'sous_titre' => $page->hero_subtitle ?? '',
                        'description' => $page->hero_description ?? '',
                        'cta_texte' => $page->hero_cta_text ?? '',
                        'cta_lien' => $page->hero_cta_url ?? '',
                        'image' => $page->hero_image,
                    ],
                    'settings' => [
                        'hauteur' => 'medium',
                        'overlay' => 40,
                        'alignement' => 'center',
                    ],
                    'order' => $order++,
                    'is_visible' => true,
                    'is_locked' => false,
                ]);

                $this->command->info("  + Hero brick for '{$page->name}'");
            }

            // Create bricks from existing sections
            $sections = $page->sections()->orderBy('order')->get();
            foreach ($sections as $section) {
                PageBrick::create([
                    'page_id' => $page->id,
                    'brick_type' => 'texte',
                    'brick_name' => $section->title ?? 'Section',
                    'content' => [
                        'titre' => $section->title ?? '',
                        'contenu' => $section->content ?? '',
                        'image' => $section->image ?? null,
                    ],
                    'settings' => [
                        'position_image' => filled($section->image) ? 'right' : 'none',
                        'couleur_fond' => '#ffffff',
                    ],
                    'order' => $order++,
                    'is_visible' => $section->is_visible ?? true,
                    'is_locked' => false,
                ]);

                $this->command->info("  + Texte brick '{$section->title}' for '{$page->name}'");
            }

            // Add a CTA brick at the end of each page
            PageBrick::create([
                'page_id' => $page->id,
                'brick_type' => 'cta',
                'brick_name' => 'Appel à l\'action',
                'content' => [
                    'titre' => 'Besoin d\'un audit GTB ?',
                    'sous_titre' => 'Nos experts analysent gratuitement votre installation',
                    'bouton_texte' => 'Demander un audit gratuit',
                    'bouton_lien' => '/audit',
                ],
                'settings' => [
                    'style' => 'primary',
                ],
                'order' => $order++,
                'is_visible' => true,
                'is_locked' => false,
            ]);

            $this->command->info("  + CTA brick for '{$page->name}'");
            $this->command->info("=> {$page->name}: {$order} bricks created.");
        }
    }
}
