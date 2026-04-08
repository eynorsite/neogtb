<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Fix : 2 catégories distinctes "Guides" (créée par BlogSeeder historique) et "Guide"
 * (créée par BlogArticlesImportSeeder) cohabitaient en base.
 *
 * Cette migration :
 *  1. Cherche les 2 catégories par leurs slugs
 *  2. Réassigne tous les posts de "Guides" vers "Guide"
 *  3. Supprime la catégorie "Guides"
 *
 * Idempotente : peut être relancée sans risque.
 */
return new class extends Migration
{
    public function up(): void
    {
        $guidesPlural = DB::table('post_categories')->where('slug', 'guides')->first();
        $guideSingular = DB::table('post_categories')->where('slug', 'guide')->first();

        if (! $guidesPlural) {
            return;
        }

        if (! $guideSingular) {
            DB::table('post_categories')
                ->where('id', $guidesPlural->id)
                ->update([
                    'name'       => 'Guide',
                    'slug'       => 'guide',
                    'updated_at' => now(),
                ]);
            return;
        }

        DB::table('posts')
            ->where('category_id', $guidesPlural->id)
            ->update(['category_id' => $guideSingular->id]);

        DB::table('post_categories')->where('id', $guidesPlural->id)->delete();
    }

    public function down(): void
    {
        // Pas de rollback : on ne recrée pas la catégorie "Guides" (c'était un doublon)
    }
};
