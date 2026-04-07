<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * GenerateurCeePageSeeder — seed la page Générateur CEE à partir
 * de resources/views/front/generateur-cee.blade.php.
 *
 * Le wizard multi-étapes Alpine.js (calcul CEE BAT-TH-116 / BAT-TH-112)
 * reste rendu dans la blade ; un brick "texte" placeholder marque sa
 * position pour pouvoir éditer l'éditorial autour depuis Filament.
 */
class GenerateurCeePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'generateur-cee')->first();
        if (!$page) {
            $this->command->error('Page Générateur CEE introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Générateur CEE supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Générateur CEE',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Estimation gratuite',
                'pre_titre' => 'NeoGTB',
                'titre' => 'Estimez vos primes CEE en 3 minutes',
                'description' => 'Simulateur indépendant basé sur les fiches BAT-TH-116 (système de régulation par programmation horaire) et BAT-TH-112 (GTB pour le chauffage et l\'ECS). Calcul transparent, sans intermédiaire.',
                'image' => '/images/hero-cee.webp',
                'image_alt' => 'Estimation des Certificats d\'Économies d\'Énergie pour un projet GTB',
                'cta_texte' => 'Lancer la simulation',
                'cta_lien' => '#wizard',
                'cta2_texte' => 'Comprendre les CEE',
                'cta2_lien' => '/blog/cee-gtb-guide',
                'stats' => [
                    ['valeur' => '3 min', 'label' => 'pour obtenir une estimation'],
                    ['valeur' => '2 fiches', 'label' => 'BAT-TH-116 & BAT-TH-112'],
                    ['valeur' => '0 €', 'label' => 'sans intermédiaire'],
                ],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-bottom', 'alignement' => 'center'],
        ]);

        // === 2. PLACEHOLDER — Wizard Alpine.js ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'texte',
            'brick_name' => 'Placeholder — Wizard CEE interactif',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Simulateur CEE — wizard multi-étapes',
                'contenu' => '<!-- GENERATEUR_CEE_WIZARD_PLACEHOLDER -->'
                    . '<p>Cet emplacement marque la position du wizard Alpine.js (calcul des primes CEE selon les fiches BAT-TH-116 et BAT-TH-112) qui reste rendu directement dans la blade <code>front/generateur-cee.blade.php</code>.</p>'
                    . '<p>Modifier les étapes, formules et barèmes se fait dans la blade — pas depuis l\'admin.</p>',
            ],
            'settings' => ['style' => 'placeholder', 'fond' => 'dark-50'],
        ]);

        // === 3. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA final — Validation projet CEE',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Estimation prometteuse ? Sécurisons votre dossier CEE.',
                'sous_titre' => 'Cahier des charges, choix de l\'obligé, vérification d\'éligibilité — un accompagnement neutre, sans intermédiaire commissionné.',
                'bouton_texte' => 'En discuter',
                'bouton_lien' => '/contact',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> GenerateurCeePageSeeder : {$order} bricks créées pour la page Générateur CEE.");
    }
}
