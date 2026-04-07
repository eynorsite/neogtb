<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ajoute une colonne `version` (lock optimiste) sur page_bricks.
 * Démarre à 1 pour toutes les bricks existantes. Incrémentée à chaque autosave
 * pour détecter les conflits multi-onglets.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('page_bricks')) {
            return;
        }

        if (!Schema::hasColumn('page_bricks', 'version')) {
            Schema::table('page_bricks', function (Blueprint $table) {
                $table->unsignedInteger('version')->default(1)->after('is_visible');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('page_bricks') && Schema::hasColumn('page_bricks', 'version')) {
            Schema::table('page_bricks', function (Blueprint $table) {
                $table->dropColumn('version');
            });
        }
    }
};
