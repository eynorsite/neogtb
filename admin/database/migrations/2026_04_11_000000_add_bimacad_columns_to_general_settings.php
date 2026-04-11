<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            // Code APE (mentions légales)
            if (!Schema::hasColumn('general_settings', 'company_ape')) {
                $table->string('company_ape', 10)->nullable()->after('company_rcs');
            }

            // Dark mode préparation
            if (!Schema::hasColumn('general_settings', 'color_scheme')) {
                $table->enum('color_scheme', ['light', 'dark'])->default('light')->after('shadow_style');
            }

            // Recherche dans la navigation
            if (!Schema::hasColumn('general_settings', 'nav_show_search')) {
                $table->boolean('nav_show_search')->default(true)->after('nav_sticky');
                $table->string('nav_search_placeholder')->nullable()->after('nav_show_search');
            }

            // Vidéo hero
            if (!Schema::hasColumn('general_settings', 'hero_video_url')) {
                $table->string('hero_video_url')->nullable()->after('hero_title_line2');
                $table->string('hero_video_type')->nullable()->after('hero_video_url');
            }

            // Crisp Chat
            if (!Schema::hasColumn('general_settings', 'crisp_chat_id')) {
                $table->string('crisp_chat_id')->nullable()->after('hotjar_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $columns = [
                'company_ape',
                'color_scheme',
                'nav_show_search',
                'nav_search_placeholder',
                'hero_video_url',
                'hero_video_type',
                'crisp_chat_id',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('general_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
