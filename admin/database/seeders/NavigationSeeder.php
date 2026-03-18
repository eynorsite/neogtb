<?php

namespace Database\Seeders;

use App\Models\NavigationMenu;
use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        // Header
        $header = NavigationMenu::firstOrCreate(
            ['location' => 'header'],
            ['name' => 'Navigation principale', 'is_active' => true]
        );

        $headerItems = [
            ['label' => 'Accueil', 'url' => '/', 'order' => 1],
            ['label' => 'GTB', 'url' => '/gtb', 'order' => 2],
            ['label' => 'GTC', 'url' => '/gtc', 'order' => 3],
            ['label' => 'Solutions', 'url' => '/solutions', 'order' => 4],
            ['label' => 'Comparateur', 'url' => '/comparateur', 'order' => 5],
            ['label' => 'Blog', 'url' => '/blog', 'order' => 6],
            ['label' => 'Audit gratuit', 'url' => '/audit', 'order' => 7],
            ['label' => 'Contact', 'url' => '/contact', 'order' => 8],
        ];

        foreach ($headerItems as $item) {
            NavigationItem::firstOrCreate(
                ['menu_id' => $header->id, 'label' => $item['label']],
                array_merge($item, ['menu_id' => $header->id, 'is_active' => true])
            );
        }

        // Footer
        $footer = NavigationMenu::firstOrCreate(
            ['location' => 'footer'],
            ['name' => 'Footer', 'is_active' => true]
        );

        $footerItems = [
            ['label' => 'GTB', 'url' => '/gtb', 'order' => 1],
            ['label' => 'GTC', 'url' => '/gtc', 'order' => 2],
            ['label' => 'Solutions', 'url' => '/solutions', 'order' => 3],
            ['label' => 'Comparateur', 'url' => '/comparateur', 'order' => 4],
            ['label' => 'Blog', 'url' => '/blog', 'order' => 5],
            ['label' => 'Audit gratuit', 'url' => '/audit', 'order' => 6],
            ['label' => 'Contact', 'url' => '/contact', 'order' => 7],
        ];

        foreach ($footerItems as $item) {
            NavigationItem::firstOrCreate(
                ['menu_id' => $footer->id, 'label' => $item['label']],
                array_merge($item, ['menu_id' => $footer->id, 'is_active' => true])
            );
        }

        $this->command->info('Navigation header + footer injectée.');
    }
}
