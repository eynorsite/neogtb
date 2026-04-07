<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * AuditPageSeeder — seed la page "Pré-diagnostic GTB"
 * à partir de resources/views/front/audit.blade.php.
 *
 * NOTE IMPORTANTE :
 * La page audit contient un wizard Alpine.js multi-étapes (8 questions, calcul
 * de score, génération PDF) trop interactif pour être brick-ifié intégralement.
 * Ce seeder pose donc :
 *   - un brick hero (éditable)
 *   - un brick cartes "Comment ça marche" (éditable)
 *   - un brick texte contenant le placeholder <!-- WIZARD_ALPINE_PLACEHOLDER -->
 *     que la blade audit.blade.php devra détecter et remplacer par le bloc
 *     wizard Alpine d'origine au moment du rendu.
 */
class AuditPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::firstOrCreate(
            ['slug' => 'audit'],
            [
                'title' => 'Pré-diagnostic GTB gratuit',
                'meta_title' => 'Pré-diagnostic GTB gratuit — Évaluez en 5 min — NeoGTB',
                'meta_description' => 'Évaluez la conformité GTB de votre bâtiment (décret BACS), estimez vos économies et recevez un rapport PDF avec recommandations ISO 52120-1.',
                'is_published' => true,
            ]
        );

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Audit supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Pré-diagnostic GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Pré-diagnostic gratuit · 5 min',
                'pre_titre' => 'NeoGTB',
                'titre' => 'Évaluez la maturité GTB de votre bâtiment',
                'description' => "Diagnostic en 8 questions basé sur la norme ISO 52120-1 (ex-EN 15232). Obtenez votre classe GTB estimée (A/B/C/D), un benchmark énergétique et des recommandations personnalisées.",
                'image' => '/images/hero-audit.webp',
                'image_alt' => 'Tableau de bord d\'évaluation GTB — pré-diagnostic NeoGTB',
                'cta_texte' => 'Démarrer le diagnostic',
                'cta_lien' => '#wizard',
                'tags' => ['ISO 52120-1', 'Décret BACS', 'Gratuit'],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-bottom', 'alignement' => 'center'],
        ]);

        // === 2. COMMENT ÇA MARCHE (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Comment ça marche',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Méthodologie',
                'titre_section' => 'Comment ça marche',
                'sous_titre' => 'Un parcours guidé en 8 étapes pour évaluer objectivement la maturité technique de votre bâtiment.',
                'cartes' => [
                    ['categorie' => 'Étape 1', 'titre' => 'Décrivez votre bâtiment', 'description' => 'Type, surface utile, zone climatique (H1, H2, H3 ou DOM).'],
                    ['categorie' => 'Étape 2', 'titre' => 'Identifiez vos lots techniques', 'description' => 'CVC, éclairage, ECS, stores, comptage… afin de calibrer le diagnostic.'],
                    ['categorie' => 'Étape 3', 'titre' => 'Régulation CVC', 'description' => 'Niveau de régulation : manuel, thermostats, programmation horaire ou optimisation auto.'],
                    ['categorie' => 'Étape 4', 'titre' => 'Gestion de l\'éclairage', 'description' => 'Interrupteurs, minuteries, détection de présence ou daylight harvesting.'],
                    ['categorie' => 'Étape 5', 'titre' => 'Suivi des consommations', 'description' => 'Aucun, manuel, sous-comptage automatique ou monitoring temps réel.'],
                    ['categorie' => 'Étape 6', 'titre' => 'Supervision', 'description' => 'Aucune, partielle, GTC multi-lots ou GTB complète avec pilotage.'],
                    ['categorie' => 'Étape 7', 'titre' => 'Maintenance', 'description' => 'Curatif, préventif planifié, conditionnel ou prédictif.'],
                    ['categorie' => 'Étape 8', 'titre' => 'Conformité', 'description' => 'Décret tertiaire et décret BACS : inconnu, partiel, en cours ou conforme.'],
                ],
            ],
            'settings' => ['colonnes' => 4, 'fond' => 'dark-50'],
        ]);

        // === 3. WIZARD PLACEHOLDER ===
        // Ce brick est rendu par la blade audit.blade.php qui détecte
        // le placeholder et le remplace par le bloc wizard Alpine d'origine.
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'texte',
            'brick_name' => 'Wizard Alpine (placeholder)',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => null,
                'contenu' => '<!-- WIZARD_ALPINE_PLACEHOLDER -->',
            ],
            'settings' => ['largeur' => 'full', 'placeholder' => true],
        ]);

        // === 4. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA — Discuter de votre projet',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Besoin d\'aller plus loin que le pré-diagnostic ?',
                'sous_titre' => 'Échangeons sur votre projet GTB. Aucune obligation, aucun argumentaire commercial.',
                'bouton_texte' => 'Prendre contact',
                'bouton_lien' => '/contact',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated'],
        ]);

        $this->command->info("=> AuditPageSeeder : {$order} bricks créées pour la page Audit.");
    }
}
