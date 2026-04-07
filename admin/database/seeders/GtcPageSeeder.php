<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * GtcPageSeeder — seed la page "Qu'est-ce que la GTC ?"
 * à partir de resources/views/front/gtc.blade.php.
 */
class GtcPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::firstOrCreate(
            ['slug' => 'gtc'],
            [
                'title' => "Qu'est-ce que la GTC ?",
                'meta_title' => "Qu'est-ce que la GTC ? Différences avec la GTB",
                'meta_description' => 'Guide GTC : définition, différences avec la GTB, architecture type, protocoles OPC-UA/BACnet/Modbus et supervision multi-sites.',
                'is_published' => true,
            ]
        );

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page GTC supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Qu\'est-ce que la GTC ?',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Comprendre',
                'titre' => 'Qu\'est-ce que la GTC ?',
                'description' => "La Gestion Technique Centralisée (GTC) désigne le système de supervision qui regroupe la surveillance et le pilotage de tous les équipements techniques d'un ou plusieurs bâtiments sur une interface unique.",
                'image' => '/images/hero-gtc.webp',
                'image_alt' => 'Bâtiment tertiaire intelligent — supervision GTC centralisée',
                'tags' => ['Supervision', 'Multi-sites', 'SCADA'],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-left', 'alignement' => 'left'],
        ]);

        // === 2. DÉFINITION (texte) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'texte',
            'brick_name' => 'Définition et rôle de la GTC',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Définition et rôle de la GTC',
                'contenu' => "<p>La <strong>Gestion Technique Centralisée (GTC)</strong> désigne un système informatique dédié à la supervision des lots techniques d'un patrimoine immobilier. Elle collecte en temps réel les données remontées par les capteurs et automates et les restitue sur des synoptiques graphiques accessibles depuis un poste central ou un navigateur web.</p>"
                    . "<p>Contrairement à un simple tableau de bord, la GTC offre une <strong>couche de supervision active</strong> : déclenchement d'alarmes en cas de dérive, historisation des mesures pour analyse de tendance, et possibilité d'envoyer des commandes simples aux équipements distants.</p>"
                    . "<p>Dans le monde anglo-saxon, elle est souvent assimilée à un système de type <strong>SCADA</strong> (Supervisory Control And Data Acquisition) appliqué au bâtiment.</p>"
                    . "<p><strong>Point clé :</strong> La GTC centralise la supervision de plusieurs sites ou de plusieurs lots techniques sur une plateforme unique. Elle remonte l'information, détecte les anomalies et permet un pilotage à distance, mais ne porte pas la régulation fine des équipements — c'est le rôle de la GTB.</p>",
            ],
            'settings' => ['largeur' => 'narrow'],
        ]);

        // === 3. COMPARATIF GTB vs GTC ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'comparatif',
            'brick_name' => 'GTB vs GTC : différences factuelles',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Comparaison',
                'titre' => 'GTB vs GTC : différences factuelles',
                'sous_titre' => 'Les deux acronymes sont fréquemment utilisés de manière interchangeable. Pourtant, ils recouvrent des périmètres distincts.',
                'colonnes' => [
                    [
                        'titre' => 'GTB — Gestion Technique du Bâtiment',
                        'points' => [
                            'Périmètre : un bâtiment, tous lots confondus',
                            'Fonction : piloter, réguler et optimiser',
                            'Régulation intégrée (boucles PID, lois d\'eau)',
                            'Utilisateur : technicien, energy manager',
                            'Protocoles : BACnet, LON, KNX',
                            'Équivalent : BMS (Building Management System)',
                        ],
                    ],
                    [
                        'titre' => 'GTC — Gestion Technique Centralisée',
                        'highlight' => true,
                        'points' => [
                            'Périmètre : plusieurs bâtiments ou un parc',
                            'Fonction : superviser, centraliser, alerter',
                            'Régulation limitée (marche/arrêt)',
                            'Utilisateur : gestionnaire de patrimoine',
                            'Protocoles : BACnet/IP, Modbus TCP, OPC-UA',
                            'Équivalent : SCADA / BCS',
                        ],
                    ],
                ],
                'note' => 'La GTB pilote et optimise un bâtiment de l\'intérieur. La GTC supervise un parc depuis un point central. Dans les projets complexes, les deux cohabitent.',
            ],
            'settings' => ['fond' => 'dark-50'],
        ]);

        // === 4. FONCTIONS PRINCIPALES (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Fonctions principales d\'une GTC',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Fonctionnalités',
                'titre_section' => 'Fonctions principales d\'une GTC',
                'sous_titre' => 'De la supervision en temps réel au reporting réglementaire, la GTC couvre l\'ensemble du cycle de vie opérationnel.',
                'cartes' => [
                    ['categorie' => 'Temps réel', 'titre' => 'Supervision en temps réel', 'description' => 'Affichage continu de l\'état des équipements sur des synoptiques graphiques.'],
                    ['categorie' => 'Alertes', 'titre' => 'Gestion des alarmes', 'description' => 'Génération d\'alarmes classées par priorité, horodatées et transmises par notification.'],
                    ['categorie' => 'Données', 'titre' => 'Historisation et reporting', 'description' => 'Archivage en base de toutes les données collectées. Rapports périodiques.'],
                    ['categorie' => 'Commande', 'titre' => 'Pilotage à distance', 'description' => 'Envoi de commandes aux équipements distants. Réduction des déplacements sur site.'],
                    ['categorie' => 'Conformité', 'titre' => 'Reporting réglementaire', 'description' => 'Collecte des données pour le décret BACS et le décret tertiaire.'],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 5. ARCHITECTURE 4 NIVEAUX (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Architecture type d\'une GTC',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Infrastructure',
                'titre_section' => 'Architecture type d\'une GTC',
                'sous_titre' => 'Une GTC repose sur une architecture à quatre niveaux, du terrain jusqu\'à l\'interface de supervision.',
                'cartes' => [
                    ['badge' => 'Niveau 1', 'titre' => 'Terrain', 'description' => 'Capteurs et actionneurs : sondes, compteurs, détecteurs, vannes motorisées.'],
                    ['badge' => 'Niveau 2', 'titre' => 'Automates', 'description' => 'Contrôleurs DDC qui collectent les informations et exécutent la logique locale.'],
                    ['badge' => 'Niveau 3', 'titre' => 'Réseau IP', 'description' => 'Fédère les automates via BACnet/IP, Modbus TCP ou OPC-UA sur Ethernet.', 'highlight' => true],
                    ['badge' => 'Niveau 4', 'titre' => 'Supervision', 'description' => 'Serveur GTC : base historique, moteur d\'alarmes, synoptiques, reporting.'],
                ],
            ],
            'settings' => ['colonnes' => 4, 'fond' => 'dark-50'],
        ]);

        // === 6. CAS D'USAGE (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Cas d\'usage GTC',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Applications',
                'titre_section' => 'Cas d\'usage',
                'sous_titre' => 'La GTC prend tout son sens dès lors qu\'il s\'agit de superviser un patrimoine réparti sur plusieurs sites.',
                'cartes' => [
                    ['categorie' => 'Multi-sites', 'titre' => 'Parcs immobiliers tertiaires', 'description' => 'Consolider les données énergétiques de plusieurs immeubles et détecter les dérives en temps réel.'],
                    ['categorie' => 'Campus', 'titre' => 'Enseignement et santé', 'description' => 'Vision unifiée d\'un campus universitaire ou hospitalier multi-bâtiments.'],
                    ['categorie' => 'Collectivités', 'titre' => 'Communes et intercommunalités', 'description' => 'Piloter écoles, gymnases, médiathèques depuis un poste central.'],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 7. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA — Évaluez votre supervision',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Évaluez votre système de supervision',
                'sous_titre' => "Identifiez les points d'amélioration de votre installation GTC et vérifiez sa conformité réglementaire.",
                'bouton_texte' => 'Lancer le diagnostic',
                'bouton_lien' => '/audit',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated'],
        ]);

        $this->command->info("=> GtcPageSeeder : {$order} bricks créées pour la page GTC.");
    }
}
