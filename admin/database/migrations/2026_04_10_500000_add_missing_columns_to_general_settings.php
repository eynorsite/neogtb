<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            // Navigation items
            if (!Schema::hasColumn('general_settings', 'nav_items')) {
                $table->json('nav_items')->nullable()->after('nav_sticky');
            }

            // Hero
            if (!Schema::hasColumn('general_settings', 'hero_default_image')) {
                $table->string('hero_default_image')->nullable()->after('og_default_image');
                $table->string('hero_style')->default('static')->after('hero_default_image');
                $table->string('hero_title_line1')->nullable()->after('hero_style');
                $table->string('hero_title_line2')->nullable()->after('hero_title_line1');
            }

            // Catalogues
            if (!Schema::hasColumn('general_settings', 'blog_categories_config')) {
                $table->json('blog_categories_config')->nullable()->after('comparateur_page_config');
                $table->json('gtb_protocols_config')->nullable()->after('blog_categories_config');
                $table->json('en15232_levels_config')->nullable()->after('gtb_protocols_config');
                $table->json('font_pairs_config')->nullable()->after('en15232_levels_config');
            }

            // Logos clients, IPs maintenance
            if (!Schema::hasColumn('general_settings', 'client_logos')) {
                $table->json('client_logos')->nullable()->after('font_pairs_config');
                $table->json('maintenance_allowed_ips')->nullable()->after('maintenance_image');
            }

            // Stats auto-calcul
            if (!Schema::hasColumn('general_settings', 'stat_buildings_auto')) {
                $table->boolean('stat_buildings_auto')->default(true)->after('stat_buildings_audited');
                $table->boolean('stat_clients_auto')->default(true)->after('stat_clients_count');
            }

            // Annonce dismissable
            if (!Schema::hasColumn('general_settings', 'announcement_dismissable')) {
                $table->boolean('announcement_dismissable')->default(true)->after('announcement_text_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $columns = [
                'nav_items',
                'hero_default_image', 'hero_style', 'hero_title_line1', 'hero_title_line2',
                'blog_categories_config', 'gtb_protocols_config', 'en15232_levels_config', 'font_pairs_config',
                'client_logos', 'maintenance_allowed_ips',
                'stat_buildings_auto', 'stat_clients_auto',
                'announcement_dismissable',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('general_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
