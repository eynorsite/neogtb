<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * SolutionsPageSeeder — seed la page Solutions & Technologies à partir
 * de resources/views/front/solutions.blade.php.
 *
 * Reprend les sections : hero, cartes catalogue protocoles
 * (BACnet, KNX, Modbus, LON, DALI, MQTT, EnOcean) et CTA final
 * vers le comparateur.
 */
class SolutionsPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'solutions')->first();
        if (!$page) {
            $this->command->error('Page Solutions introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Solutions supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Solutions & technologies GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Technologies',
                'pre_titre' => 'NeoGTB',
                'titre' => 'Solutions & technologies GTB',
                'description' => 'Les protocoles de communication, capteurs, contrôleurs et superviseurs qui composent un système de gestion technique du bâtiment. Architecture ouverte et interopérable.',
                'image' => '/images/hero-solutions.webp',
                'image_alt' => 'Technologies GTB — capteurs IoT, protocoles et supervision connectée',
                'cta_texte' => 'Comparer les solutions',
                'cta_lien' => '/comparateur',
                'cta2_texte' => 'Lancer le pré-diagnostic',
                'cta2_lien' => '/audit',
                'stats' => [
                    ['valeur' => '7+', 'label' => 'protocoles couverts'],
                    ['valeur' => '6', 'label' => 'lots techniques pilotés'],
                    ['valeur' => '5', 'label' => 'couches d\'architecture'],
                ],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-left', 'alignement' => 'left'],
        ]);

        // === 2. CARTES — Catalogue protocoles ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Catalogue protocoles GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Fondations',
                'titre_section' => 'Protocoles de communication',
                'sous_titre' => 'Le protocole est le langage commun entre équipements. Le choix conditionne l\'interopérabilité, la maintenabilité et la pérennité de l\'installation.',
                'cartes' => [
                    [
                        'tag' => 'ISO 16484-5',
                        'titre' => 'BACnet',
                        'description' => 'Standard international de la GTB (ASHRAE). BACnet IP sur Ethernet, BACnet MS/TP sur RS-485. Modèle objet unifié, interopérabilité multi-marques sans passerelle propriétaire.',
                        'tags' => ['Interopérabilité', 'IP / MS/TP', 'ASHRAE 135'],
                    ],
                    [
                        'tag' => 'EN 50090',
                        'titre' => 'KNX',
                        'description' => 'Standard européen de l\'automatisation du bâtiment. Bus filaire TP. Plus de 500 fabricants certifiés. Très utilisé en éclairage, stores et CVC en résidentiel et petit tertiaire.',
                        'tags' => ['500+ fabricants', 'Bus TP', 'Éclairage / CVC'],
                    ],
                    [
                        'tag' => 'RTU / TCP',
                        'titre' => 'Modbus',
                        'description' => 'Protocole industriel (Modicon, 1979) devenu standard de fait. Modbus RTU sur RS-485 et Modbus TCP sur Ethernet. Architecture maître-esclave, dominant pour le comptage énergie.',
                        'tags' => ['Industriel', 'RS-485 / Ethernet', 'Comptage'],
                    ],
                    [
                        'tag' => 'EN 14908',
                        'titre' => 'LON',
                        'description' => 'Local Operating Network (Echelon). Architecture peer-to-peer, chaque noeud embarque son intelligence. En déclin face à BACnet IP mais encore présent dans le parc existant.',
                        'tags' => ['Peer-to-peer', 'Parc existant', 'Migration'],
                    ],
                    [
                        'tag' => 'IEC 62386',
                        'titre' => 'DALI / DALI-2',
                        'description' => 'Standard international dédié au pilotage de l\'éclairage. DALI-2 apporte l\'interopérabilité certifiée. Jusqu\'à 64 appareils par ligne, adressage individuel, gradation fine.',
                        'tags' => ['Éclairage', '64 appareils/ligne', 'Gradation'],
                    ],
                    [
                        'tag' => 'IoT / Cloud',
                        'titre' => 'MQTT & API REST',
                        'description' => 'Protocoles issus du monde IT pour l\'interopérabilité cloud, les jumeaux numériques et l\'hypervision multi-sites. MQTT léger pour capteurs IoT, API REST pour GMAO/ERP/analytics.',
                        'tags' => ['Pub/Sub', 'Cloud natif', 'Hypervision'],
                    ],
                    [
                        'tag' => 'ISO/IEC 14543-3-10',
                        'titre' => 'EnOcean',
                        'description' => 'Sans fil et sans pile, basé sur la récupération d\'énergie (piézo, solaire, thermique). Idéal pour la rénovation où le câblage est impossible ou coûteux.',
                        'tags' => ['Sans fil', 'Sans pile', 'Rénovation'],
                    ],
                ],
            ],
            'settings' => ['colonnes' => 2],
        ]);

        // === 3. CARTES — Lots techniques pilotés ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Équipements pilotés — 6 lots techniques',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Périmètre',
                'titre_section' => 'Équipements pilotés',
                'sous_titre' => 'La GTB supervise et régule l\'ensemble des lots techniques d\'un bâtiment.',
                'cartes' => [
                    ['tag' => 'Lot 01', 'titre' => 'CVC — Chauffage, ventilation, climatisation', 'description' => 'CTA, chaudières, groupes froids, ventilo-convecteurs. 50 à 60 % de la consommation d\'un bâtiment tertiaire.'],
                    ['tag' => 'Lot 02', 'titre' => 'Éclairage', 'description' => 'Gestion par zones, horloges, détection de présence, mesure de luminosité. Pilotage DALI ou 0-10V.'],
                    ['tag' => 'Lot 03', 'titre' => 'Stores et BSO', 'description' => 'Brise-soleil et stores. Pilotage selon l\'ensoleillement, la température et les scénarios d\'occupation.'],
                    ['tag' => 'Lot 04', 'titre' => 'Contrôle d\'accès', 'description' => 'Lecteurs, interphones, portiques. Intégration GTB pour adapter CVC et éclairage à l\'occupation réelle.'],
                    ['tag' => 'Lot 05', 'titre' => 'Comptage énergie', 'description' => 'Sous-comptage électrique, thermique, gaz, eau. Base du suivi exigé par le décret tertiaire (OPERAT).'],
                    ['tag' => 'Lot 06', 'titre' => 'Sécurité incendie', 'description' => 'Report SSI vers le superviseur, désenfumage, coupures CVC sur détection. Autonomie SSI conservée (NF S 61-932).'],
                ],
            ],
            'settings' => ['colonnes' => 3, 'fond' => 'dark-50'],
        ]);

        // === 4. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA final — Comparateur',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Comparer les solutions du marché',
                'sous_titre' => 'Notre comparateur indépendant analyse les superviseurs GTB, protocoles et intégrateurs selon des critères objectifs.',
                'bouton_texte' => 'Accéder au comparateur',
                'bouton_lien' => '/comparateur',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> SolutionsPageSeeder : {$order} bricks créées pour la page Solutions.");
    }
}
