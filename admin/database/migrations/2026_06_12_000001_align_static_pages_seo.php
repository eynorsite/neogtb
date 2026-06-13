<?php

use App\Http\Controllers\StaticPageController;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Réalignement ponctuel du SEO des pages statiques.
 *
 * Contexte : avant ce lot, le champ « Référencement Google » de ces pages était
 * IGNORÉ (StaticPageController servait des titres en dur). Ce que Google voit
 * aujourd'hui = ces titres optimisés (self::DEFAULT_SEO). Or les SitePage en base
 * portent des meta_title FAIBLES issus des seeders. Maintenant que le contrôleur
 * lit la base en priorité (repli filled()), il FAUT aligner la base sur les valeurs
 * optimisées, sinon le titre faible écraserait le bon dès le déploiement.
 *
 * Sûr : on remplace des valeurs jamais rendues (champ non fonctionnel jusqu'ici)
 * par celles déjà servies. N'affecte que les lignes existantes (0 ligne = repli).
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (StaticPageController::DEFAULT_SEO as $slug => $seo) {
            DB::table('site_pages')
                ->where('slug', $slug)
                ->whereNull('deleted_at')
                ->update([
                    'meta_title' => $seo['title'],
                    'meta_description' => $seo['description'],
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // Réalignement ponctuel de données : aucune restauration automatique.
    }
};
