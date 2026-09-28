<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Machine à articles Notion (28/09/2026).
 *
 * - notion_page_id : rattache un article à sa page Notion (synchro idempotente,
 *   l'adresse d'un article ne change jamais).
 * - notion_scheduled : article reçu de Notion avec une date future. Il reste en
 *   « draft » (donc invisible : blog, sitemap, llms.txt, IndexNow ne lisent que
 *   « published ») jusqu'à sa date, puis notion:sync-articles le publie.
 *   La colonne status (enum draft/published/archived, contrainte CHECK en
 *   SQLite) n'est pas touchée : pas de nouvel état à propager partout.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('notion_page_id')->nullable()->unique();
            $table->boolean('notion_scheduled')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique(['notion_page_id']);
            $table->dropColumn(['notion_page_id', 'notion_scheduled']);
        });
    }
};
