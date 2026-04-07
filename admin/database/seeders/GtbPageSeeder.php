<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * GtbPageSeeder — seed la page "Qu'est-ce que la GTB ?"
 * à partir de resources/views/front/gtb.blade.php.
 */
class GtbPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::firstOrCreate(
            ['slug' => 'gtb'],
            [
                'title' => "Qu'est-ce que la GTB ?",
                'meta_title' => "Qu'est-ce que la GTB ? Définition et niveaux ISO 52120-1",
                'meta_description' => 'Guide GTB : définition, 4 niveaux ISO 52120-1 (ex-EN 15232), protocoles BACnet/KNX/Modbus, décret BACS et obligations. Mis à jour 2026.',
                'is_published' => true,
            ]
        );

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page GTB supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Qu\'est-ce que la GTB ?',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Comprendre',
                'titre' => 'Qu\'est-ce que la GTB ?',
                'description' => "La Gestion Technique du Bâtiment (GTB) désigne le système centralisé qui supervise, pilote et optimise l'ensemble des équipements techniques d'un bâtiment — du chauffage à l'éclairage, en passant par la ventilation et le contrôle d'accès.",
                'image' => '/images/hero-gtb.webp',
                'image_alt' => 'Poste de supervision GTB — écrans de contrôle et alertes bâtiment',
                'tags' => ['Bâtiment intelligent', 'ISO 52120-1'],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-left', 'alignement' => 'left'],
        ]);

        // === 2. DEFINITION (texte) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'texte',
            'brick_name' => 'Définition et rôle de la GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Définition et rôle de la GTB',
                'contenu' => "<p>La <strong>Gestion Technique du Bâtiment</strong>, couramment abrégée GTB et connue en anglais sous le terme <em>Building Management System (BMS)</em>, est un système informatique qui centralise la supervision et le pilotage de tous les lots techniques d'un bâtiment.</p>"
                    . "<p>Elle collecte en temps réel les données issues de capteurs (température, hygrométrie, luminosité, présence, qualité de l'air, comptage énergétique) et transmet des commandes aux actionneurs pour maintenir les conditions de confort tout en réduisant la consommation d'énergie.</p>"
                    . "<p>Contrairement à une simple régulation locale, la GTB offre une <strong>vision globale du bâtiment</strong>. C'est cette capacité d'interopérabilité entre systèmes qui distingue une GTB d'un simple automate de régulation.</p>"
                    . "<p><strong>Point clé :</strong> Depuis le décret BACS (2020), la mise en place d'un système d'automatisation est <strong>obligatoire</strong> pour les bâtiments tertiaires dont la puissance CVC dépasse 290 kW (2025), puis 70 kW (2030).</p>",
            ],
            'settings' => ['largeur' => 'narrow'],
        ]);

        // === 3. NIVEAUX ISO 52120-1 (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Les 4 niveaux ISO 52120-1',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Classification',
                'titre_section' => 'Les 4 niveaux ISO 52120-1',
                'sous_titre' => 'La norme EN ISO 52120-1 (ex-EN 15232) définit quatre classes de performance pour les systèmes de gestion technique du bâtiment.',
                'cartes' => [
                    ['badge' => 'Classe D', 'titre' => 'Non performant', 'description' => "Aucun système d'automatisation. Pilotage manuel, sans régulation ni programmation. Référence basse à dépasser."],
                    ['badge' => 'Classe C', 'titre' => 'Standard', 'description' => "Régulation de base et programmation horaire. Régulateurs individuels sans supervision centralisée. Niveau minimal pour les bâtiments neufs."],
                    ['badge' => 'Classe B', 'titre' => 'Avancé', 'description' => "GTB centralisée, suivi énergétique, détection de dérives. Communication BACnet/KNX/Modbus. Exigence du décret BACS.", 'highlight' => true],
                    ['badge' => 'Classe A', 'titre' => 'Haute performance', 'description' => "Régulation pièce par pièce, optimisation multi-lots, analyse avancée, détection automatique des défauts, ajustement prédictif."],
                ],
            ],
            'settings' => ['colonnes' => 4, 'fond' => 'dark-50'],
        ]);

        // === 4. LOTS TECHNIQUES (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Lots techniques pilotés',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Périmètre',
                'titre_section' => 'Lots techniques pilotés',
                'sous_titre' => 'Une GTB supervise et coordonne l\'ensemble des systèmes du bâtiment.',
                'cartes' => [
                    ['categorie' => 'CVC', 'titre' => 'Chauffage, Ventilation, Climatisation', 'description' => 'Régulation des chaudières, PAC, groupes froids, CTA, ventilo-convecteurs. Gestion des consignes par zone, programmation horaire, réduit de nuit, suivi des rendements.'],
                    ['categorie' => 'Éclairage', 'titre' => 'Pilotage et gradation', 'description' => 'Pilotage par zone selon présence et luminosité naturelle. Gradation (dimming) via DALI ou KNX. Gestion des circuits de sécurité et d\'éclairage extérieur.'],
                    ['categorie' => 'Protection solaire', 'titre' => 'Stores et BSO', 'description' => 'Gestion automatisée selon ensoleillement, position du soleil, vent. Interaction CVC essentielle.'],
                    ['categorie' => 'Sécurité', 'titre' => 'Contrôle d\'accès et sûreté', 'description' => 'Supervision des lecteurs de badges, détection d\'intrusion, SSI. Couplage présence/confort.'],
                    ['categorie' => 'Énergie', 'titre' => 'Comptage et suivi énergétique', 'description' => 'Centralisation des compteurs (élec, gaz, eau, calories). Suivi des IPE, détection de dérives, reporting OPERAT.'],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 5. PROTOCOLES (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Protocoles de communication',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Interopérabilité',
                'titre_section' => 'Protocoles de communication',
                'sous_titre' => 'Le choix du protocole conditionne l\'interopérabilité, la maintenabilité et la pérennité de l\'installation.',
                'cartes' => [
                    ['categorie' => 'ISO 16484-5', 'titre' => 'BACnet MS/TP', 'description' => 'BACnet sur bus RS-485 série. Protocole terrain de référence pour automates, VAV et capteurs.'],
                    ['categorie' => 'RS-485', 'titre' => 'Modbus RTU', 'description' => 'Protocole industriel. Architecture maître-esclave sur liaison série. Dominant pour le comptage énergie.'],
                    ['categorie' => 'ISO/IEC 14543-3', 'titre' => 'KNX TP', 'description' => 'Bus filaire paire torsadée. 500+ fabricants. Standard européen pour éclairage, stores, CVC.'],
                    ['categorie' => 'IEC 62386', 'titre' => 'DALI / DALI-2', 'description' => 'Digital Addressable Lighting Interface. Bus 2 fils, 64 appareils par ligne.'],
                    ['categorie' => 'ISO 16484-5', 'titre' => 'BACnet/IP', 'description' => 'BACnet sur UDP/IP. Protocole backbone de référence pour la supervision GTB moderne.'],
                    ['categorie' => 'IEC 62541', 'titre' => 'OPC UA', 'description' => 'Standard d\'interopérabilité cross-système. Pont sécurisé entre OT et IT.'],
                ],
            ],
            'settings' => ['colonnes' => 3, 'fond' => 'dark-50'],
        ]);

        // === 6. COMPARATIF / RÉGLEMENTATION (cartes) ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Cadre réglementaire',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Conformité',
                'titre_section' => 'Cadre réglementaire',
                'sous_titre' => 'Plusieurs textes encadrent la mise en place de systèmes GTB dans les bâtiments tertiaires en France.',
                'cartes' => [
                    ['badge' => 'Obligatoire', 'titre' => 'Décret BACS', 'description' => 'Impose un système d\'automatisation (classe B min.) pour les bâtiments tertiaires. Échéance 2025 (>290 kW CVC), 2030 (>70 kW).'],
                    ['badge' => 'Objectifs', 'titre' => 'Décret tertiaire', 'description' => 'Réduction progressive : -40 % (2030), -50 % (2040), -60 % (2050). Déclaration OPERAT.'],
                    ['badge' => 'Neuf', 'titre' => 'RE2020', 'description' => 'Bâtiments neufs. Seuils Cep et confort d\'été (DH) rendant la GTB quasi indispensable.'],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 7. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA — Évaluez le niveau GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Évaluez le niveau GTB de votre bâtiment',
                'sous_titre' => "Identifiez votre classe ISO 52120-1, vérifiez votre conformité BACS et repérez les axes d'amélioration.",
                'bouton_texte' => 'Lancer le diagnostic',
                'bouton_lien' => '/audit',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated'],
        ]);

        $this->command->info("=> GtbPageSeeder : {$order} bricks créées pour la page GTB.");
    }
}
