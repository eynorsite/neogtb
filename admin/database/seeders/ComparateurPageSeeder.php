<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * ComparateurPageSeeder — seed la page Comparateur GTB à partir
 * de resources/views/front/comparateur.blade.php.
 *
 * La table interactive Alpine.js (10+ solutions GTB) reste rendue
 * dans la blade actuelle ; un brick "texte" placeholder marque sa
 * position dans la composition pour pouvoir y insérer du contenu
 * éditorial autour depuis l'admin Filament.
 */
class ComparateurPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'comparateur')->first();
        if (!$page) {
            $this->command->error('Page Comparateur introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Comparateur supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Comparateur GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Outil indépendant',
                'pre_titre' => 'NeoGTB',
                'titre' => 'Comparateur objectif GTB',
                'description' => 'Analysez et comparez les solutions des principaux acteurs du marché de la Gestion Technique du Bâtiment. Notes, protocoles, budgets et retours terrain pour un choix éclairé.',
                'image' => '/images/hero-comparateur.png',
                'image_alt' => 'Comparaison de bâtiments intelligents — GTB',
                'cta_texte' => 'Lancer le pré-diagnostic',
                'cta_lien' => '/audit',
                'cta2_texte' => 'Discuter de mon projet',
                'cta2_lien' => '/contact',
                'stats' => [
                    ['valeur' => '10+', 'label' => 'fabricants évalués'],
                    ['valeur' => '6', 'label' => 'critères objectifs'],
                    ['valeur' => '0 €', 'label' => 'commission fabricant'],
                ],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-bottom', 'alignement' => 'center'],
        ]);

        // === 2. CARTES — Critères de notation ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Critères de notation — 6 axes',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Méthodologie',
                'titre_section' => 'Six critères, pondération égale',
                'sous_titre' => 'Notation issue exclusivement de la documentation publique des constructeurs et de retours d\'expérience terrain. Aucune commission, aucun lien commercial.',
                'cartes' => [
                    ['icone' => 'plug', 'titre' => 'Ouverture protocoles', 'description' => 'BACnet, KNX, Modbus, LON, DALI, MQTT — niveau d\'interopérabilité multi-marques.'],
                    ['icone' => 'layers', 'titre' => 'Scalabilité', 'description' => 'Capacité à monter en charge : nombre de points, multi-sites, hypervision.'],
                    ['icone' => 'shield', 'titre' => 'Maturité & support', 'description' => 'Ancienneté de la gamme, réseau d\'intégrateurs certifiés, qualité du support.'],
                    ['icone' => 'euro', 'titre' => 'Coût total (TCO)', 'description' => 'Licences, automates, ingénierie, maintenance sur 10 ans.'],
                    ['icone' => 'lock-open', 'titre' => 'Indépendance', 'description' => 'Niveau de verrouillage propriétaire vs solution réellement ouverte.'],
                    ['icone' => 'gauge', 'titre' => 'Conformité ISO 52120-1', 'description' => 'Capacité à atteindre la classe B exigée par le décret BACS.'],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 3. PLACEHOLDER — Table comparateur Alpine.js ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'texte',
            'brick_name' => 'Placeholder — Table comparateur interactive',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Table comparative interactive',
                'contenu' => '<!-- COMPARATEUR_TABLE_PLACEHOLDER -->'
                    . '<p>Cet emplacement marque la position de la table comparative Alpine.js (10+ solutions GTB : Schneider, Siemens Desigo, Honeywell Niagara, Sauter, Wago, Wattsense, etc.) qui reste rendue directement dans la blade <code>front/comparateur.blade.php</code>.</p>'
                    . '<p>Modifier les filtres, colonnes et données de la table se fait dans la blade — pas depuis l\'admin.</p>',
            ],
            'settings' => ['style' => 'placeholder', 'fond' => 'dark-50'],
        ]);

        // === 4. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA final — Aide au choix',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Besoin d\'un avis indépendant sur votre cahier des charges ?',
                'sous_titre' => 'Le comparateur donne une vision macro. Pour un choix calibré sur votre bâtiment, parlons-en.',
                'bouton_texte' => 'Échanger avec NeoGTB',
                'bouton_lien' => '/contact',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> ComparateurPageSeeder : {$order} bricks créées pour la page Comparateur.");
    }
}
