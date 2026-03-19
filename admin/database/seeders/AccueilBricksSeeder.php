<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

class AccueilBricksSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'accueil')->first();
        if (!$page) {
            $this->command->error('Page Accueil not found');
            return;
        }

        // Delete existing bricks for accueil
        $page->bricks()->delete();
        $this->command->info('Deleted existing bricks for Accueil');

        $order = 0;

        // === SECTION 1: HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero',
            'brick_name' => 'Hero principal',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => '🏢 Tiers de confiance indépendant',
                'titre' => 'Le tiers de confiance indépendant de la GTB en France',
                'sous_titre' => 'Nous ne vendons rien. Nous vous aidons à comprendre, comparer et décider en toute objectivité.',
                'description' => 'Diagnostic gratuit de votre bâtiment, comparateur de marques objectif, veille réglementaire et contenus experts.',
                'cta_texte' => 'Diagnostiquer mon bâtiment',
                'cta_lien' => '/audit',
                'cta2_texte' => 'Comparer les technologies',
                'cta2_lien' => '/comparateur',
                'image' => null,
            ],
            'settings' => ['hauteur' => 'full', 'overlay' => 40, 'alignement' => 'center'],
        ]);
        $this->command->info('  + Hero');

        // === SECTION 2: COMPRENEZ COMPAREZ DECIDEZ (3 cards) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Comprenez, comparez, décidez',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre_section' => 'Comprenez, comparez, décidez',
                'cartes' => [
                    [
                        'icone' => '🔍',
                        'titre' => 'Diagnostic GTB',
                        'description' => 'Évaluez la maturité technique de votre bâtiment en 5 minutes. Rapport personnalisé gratuit.',
                        'lien' => '/audit',
                    ],
                    [
                        'icone' => '⚖️',
                        'titre' => 'Comparateur objectif',
                        'description' => '10 marques de GTB/GTC analysées objectivement. Fonctionnalités, prix, compatibilité.',
                        'lien' => '/comparateur',
                    ],
                    [
                        'icone' => '📋',
                        'titre' => 'Générateur CEE',
                        'description' => 'Estimez vos Certificats d\'Économie d\'Énergie et le retour sur investissement de votre projet GTB.',
                        'lien' => '/generateur-cee',
                    ],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);
        $this->command->info('  + Comprenez comparez décidez');

        // === SECTION 3: COMPRENDRE GTB ET GTC (2 cards) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Comprendre la GTB et la GTC',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre_section' => 'Comprendre la GTB et la GTC',
                'cartes' => [
                    [
                        'icone' => '🏢',
                        'titre' => 'Gestion Technique du Bâtiment',
                        'description' => 'Supervision, pilotage et optimisation des équipements techniques. Chauffage, ventilation, éclairage, sécurité.',
                        'lien' => '/gtb',
                    ],
                    [
                        'icone' => '⚙️',
                        'titre' => 'Gestion Technique Centralisée',
                        'description' => 'Centralisation de la supervision sur un poste unique. Alarmes, historiques, maintenance préventive.',
                        'lien' => '/gtc',
                    ],
                ],
            ],
            'settings' => ['colonnes' => 2],
        ]);
        $this->command->info('  + Comprendre GTB et GTC');

        // === SECTION 4: POURQUOI FAIRE CONFIANCE (comparatif) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'comparatif',
            'brick_name' => 'Pourquoi faire confiance à NeoGTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Pourquoi faire confiance à NeoGTB ?',
                'sous_titre' => 'Un positionnement unique dans l\'écosystème GTB français.',
                'colonne_gauche_titre' => 'Les autres acteurs GTB',
                'colonne_droite_titre' => 'NeoGTB — Tiers de confiance',
                'lignes_gauche' => [
                    ['texte' => 'Vendent leurs propres solutions'],
                    ['texte' => 'Orientent vers leurs produits'],
                    ['texte' => 'Comparatifs biaisés par les partenariats'],
                    ['texte' => 'Conseils conditionnés par les commissions'],
                    ['texte' => 'Documentation technique payante'],
                ],
                'lignes_droite' => [
                    ['texte' => '100% indépendant, aucune vente de matériel'],
                    ['texte' => 'Conseils objectifs basés sur vos besoins'],
                    ['texte' => 'Comparateur transparent et factuel'],
                    ['texte' => 'Aucune commission, aucun partenariat commercial'],
                    ['texte' => 'Contenus gratuits et accessibles à tous'],
                ],
            ],
            'settings' => [],
        ]);
        $this->command->info('  + Pourquoi confiance (comparatif)');

        // === SECTION 5: MARCHE GTB EN FRANCE (chiffres) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'chiffres',
            'brick_name' => 'Le marché GTB en France',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'stats' => [
                    ['icone' => '📉', 'valeur' => '40', 'suffixe' => '%', 'label' => 'd\'économies d\'énergie possibles'],
                    ['icone' => '💰', 'valeur' => '6', 'suffixe' => 'Md€', 'label' => 'marché GTB en France'],
                    ['icone' => '🏗️', 'valeur' => '950 000', 'suffixe' => '', 'label' => 'bâtiments tertiaires concernés'],
                ],
            ],
            'settings' => ['couleur_fond' => '#f8fafc', 'animation' => true],
        ]);
        $this->command->info('  + Marché GTB (chiffres)');

        // === SECTION 6: TECHNOLOGIES (logos) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'logos',
            'brick_name' => 'Les technologies que nous maîtrisons',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Les technologies que nous maîtrisons',
                'sous_titre' => 'Indépendant de toute marque, nous connaissons les spécificités de chaque acteur du marché.',
                'logos' => [
                    ['nom' => 'Siemens', 'image' => '/images/logos/partenaires/logo-siemens.svg', 'lien' => ''],
                    ['nom' => 'Schneider Electric', 'image' => '/images/logos/partenaires/logo-schneider.svg', 'lien' => ''],
                    ['nom' => 'Honeywell', 'image' => '/images/logos/partenaires/logo-honeywell.svg', 'lien' => ''],
                    ['nom' => 'Sauter', 'image' => '/images/logos/partenaires/logo-sauter.svg', 'lien' => ''],
                    ['nom' => 'KNX', 'image' => '/images/logos/partenaires/logo-knx.svg', 'lien' => ''],
                    ['nom' => 'Watchdog', 'image' => '/images/logos/partenaires/logo-watchdog.svg', 'lien' => ''],
                ],
            ],
            'settings' => [],
        ]);
        $this->command->info('  + Technologies (logos)');

        // === SECTION 7: CONTENUS EXPERTS (6 cards) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Explorez nos contenus experts',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre_section' => 'Explorez nos contenus experts',
                'cartes' => [
                    ['icone' => '⚡', 'titre' => 'Efficacité énergétique', 'description' => 'Optimisez la consommation de vos bâtiments grâce à la GTB.', 'lien' => '/blog'],
                    ['icone' => '📜', 'titre' => 'Réglementation', 'description' => 'RE2020, décret tertiaire, BACS : tout comprendre.', 'lien' => '/blog'],
                    ['icone' => '🔌', 'titre' => 'Protocoles & IoT', 'description' => 'BACnet, KNX, Modbus, LON : les standards expliqués.', 'lien' => '/solutions'],
                    ['icone' => '🔍', 'titre' => 'Audit & Diagnostic', 'description' => 'Évaluez la performance technique de votre bâtiment.', 'lien' => '/audit'],
                    ['icone' => '🌡️', 'titre' => 'CVC & Confort', 'description' => 'Chauffage, ventilation, climatisation : pilotage intelligent.', 'lien' => '/gtb'],
                    ['icone' => '🏙️', 'titre' => 'Smart Building', 'description' => 'L\'avenir du bâtiment intelligent connecté.', 'lien' => '/blog'],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);
        $this->command->info('  + Contenus experts (6 cartes)');

        // === SECTION 8: CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta',
            'brick_name' => 'CTA Final',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Un avis indépendant sur votre bâtiment ?',
                'sous_titre' => 'Notre diagnostic gratuit évalue votre niveau actuel et vous propose des recommandations concrètes, sans engagement commercial.',
                'bouton_texte' => 'Lancer le diagnostic gratuit',
                'bouton_lien' => '/audit',
                'bouton2_texte' => 'Comparer les technologies',
                'bouton2_lien' => '/comparateur',
            ],
            'settings' => ['style' => 'dark'],
        ]);
        $this->command->info('  + CTA final');

        $this->command->info("=> Accueil : {$order} bricks créées.");
    }
}
