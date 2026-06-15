<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @deprecated Version LEGACY de l'accueil — NEUTRALISÉE. Utilisez HomePageSeeder.
 *
 * Ce seeder portait l'ancien accueil "tiers de confiance" avec des emojis et des
 * chiffres de marché NON SOURCÉS, interdits par les règles de contenu :
 *   « 40 % d'économies », « 6 Md€ de marché », « 950 000 bâtiments ».
 * Son contenu a été RETIRÉ du dépôt (plus aucun chiffre non sourcé en git, plus
 * aucun emoji). Il est remplacé par HomePageSeeder, la version de référence de
 * l'accueil (sections alignées sur resources/views/front/accueil.blade.php, et
 * valeurs chiffrées uniquement sourcées via reglementation.blade.php).
 *
 * Le fichier est conservé (et non supprimé) pour préserver l'historique git et
 * éviter de casser une éventuelle référence par nom de classe ; le run() est vide
 * et ne touche plus la base. Il n'est appelé par aucun pipeline (absent de
 * DatabaseSeeder), donc cette neutralisation ne casse rien.
 *
 * ─────────────────────────────────────────────────────────────────────────────
 * IMPORTANT — LA COPIE LIVE N'EST PAS DANS LES SEEDERS.
 * Le front accueil ne lit plus la table page_bricks : StaticPageController::accueil()
 * lit la table `page_contents` via App\Services\ContentBrickAdapter::buildBricks('accueil').
 * La copie réellement affichée en PRODUCTION vit en BASE PROD (page_contents) et
 * s'édite dans Filament. Toute modification de contenu se fait là-bas manuellement,
 * PUIS on vide le cache (cache 1h) :  sudo -u www-data php artisan cache:clear
 */
class AccueilBricksSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder déprécié et neutralisé : il ne crée plus aucune brick.
        // Pour (re)constituer l'accueil en local, utiliser la version de référence :
        //   php artisan db:seed --class=HomePageSeeder
        $this->command->warn(
            'AccueilBricksSeeder est DÉPRÉCIÉ et neutralisé (legacy : emojis + chiffres non sourcés). '
            . 'Utilisez HomePageSeeder. Aucune brick créée.'
        );
    }
}
