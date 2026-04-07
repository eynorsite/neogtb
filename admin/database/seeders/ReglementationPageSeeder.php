<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * ReglementationPageSeeder — seed la page Réglementation à partir du contenu
 * actuel de resources/views/front/reglementation.blade.php.
 */
class ReglementationPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'reglementation')->first();
        if (!$page) {
            $this->command->error('Page Réglementation introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Réglementation supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Réglementation GTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Cadre juridique',
                'pre_titre' => 'Réglementation',
                'titre' => 'Réglementation GTB en France',
                'description' => 'Décret BACS, décret tertiaire, RE2020, directive EPBD, norme EN ISO 52120-1 : obligations, échéances et aides. Mis à jour mars 2026.',
                'image' => '/images/hero-reglementation.webp',
                'image_alt' => 'Réglementation GTB — balance juridique, normes énergétiques et bâtiment tertiaire',
                'tags' => ['Décret BACS', 'Décret tertiaire', 'RE2020', 'ISO 52120-1'],
            ],
            'settings' => ['hauteur' => 'min-480', 'overlay' => 'gradient-left', 'alignement' => 'left'],
        ]);

        // === 2. TIMELINE — BACS 2025/2030/2040/2050 ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'timeline',
            'brick_name' => 'Timeline — Calendrier BACS & Tertiaire',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Vue d\'ensemble',
                'eyebrow_color' => 'energy',
                'titre' => 'Calendrier des obligations',
                'sous_titre' => 'Toutes les échéances réglementaires liées à la GTB, actualisées après le décret de décembre 2025.',
                'points' => [
                    ['annee' => '2025', 'label' => 'BACS > 290 kW', 'detail' => 'En vigueur — bâtiments existants', 'etat' => 'present'],
                    ['annee' => '2030', 'label' => 'BACS 70-290 kW', 'detail' => 'Reporté (était 2027) — décret 2025-1343', 'etat' => 'futur'],
                    ['annee' => '2040', 'label' => 'Décret tertiaire', 'detail' => '-50 % de consommation', 'etat' => 'futur'],
                    ['annee' => '2050', 'label' => 'Décret tertiaire', 'detail' => '-60 % de consommation', 'etat' => 'futur'],
                ],
                'legende' => [
                    ['couleur' => 'energy', 'texte' => 'En vigueur'],
                    ['couleur' => 'accent', 'texte' => 'À venir'],
                ],
            ],
            'settings' => ['fond' => 'white-bordered'],
        ]);

        // === 3. CARTES DÉCRETS ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Cartes — Décrets et directives',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Cadre réglementaire',
                'titre_section' => 'Les textes qui encadrent la GTB',
                'sous_titre' => 'Du décret français à la directive européenne, panorama des obligations clés.',
                'cartes' => [
                    [
                        'badge' => 'Obligation principale',
                        'titre' => 'Décret BACS',
                        'sous_titre' => 'Décret n° 2020-887 modifié par 2025-1343',
                        'description' => 'Transpose l\'article 14 de la directive EPBD. Impose une GTB de classe B minimum (ISO 52120-1) capable de suivre, analyser et piloter les consommations CVC. Inspection régulière obligatoire.',
                    ],
                    [
                        'badge' => 'Objectifs de réduction',
                        'titre' => 'Décret tertiaire',
                        'sous_titre' => 'Décret n° 2019-771 — loi ELAN',
                        'description' => 'Bâtiments tertiaires > 1 000 m² : -40 % en 2030, -50 % en 2040, -60 % en 2050. Déclaration annuelle OPERAT (ADEME). Amende jusqu\'à 7 500 € par bâtiment.',
                    ],
                    [
                        'badge' => 'Neuf depuis 2022',
                        'titre' => 'RE2020',
                        'sous_titre' => 'Réglementation Environnementale 2020',
                        'description' => 'Renforce les exigences de la RT2012 et introduit le carbone cycle de vie. Indicateurs Cep et DH rendent la GTB quasi indispensable en tertiaire neuf.',
                    ],
                    [
                        'badge' => 'Europe / refonte 2024',
                        'titre' => 'Directive EPBD',
                        'sous_titre' => 'Energy Performance of Buildings Directive 2018/844',
                        'description' => 'Texte européen fondateur. Article 14 = origine du décret BACS. Refonte 2024 : bâtiments à émission zéro 2050, passeport rénovation, abaissement des seuils.',
                    ],
                    [
                        'badge' => 'Référentiel technique',
                        'titre' => 'EN ISO 52120-1 (ex-EN 15232)',
                        'sous_titre' => 'Norme de classement A à D',
                        'description' => 'Classe D non performant, C standard, B avancé (exigence BACS), A haute performance. Gains D→B : ~25 % global, jusqu\'à 30 % CVC en bureaux.',
                    ],
                    [
                        'badge' => 'Aides financières',
                        'titre' => 'CEE — BAT-TH-116 / BAT-TH-112',
                        'sous_titre' => 'Certificats d\'Économies d\'Énergie',
                        'description' => 'BAT-TH-116 finance l\'installation GTB classe A ou B. BAT-TH-112 couvre les variateurs de vitesse moteurs CVC. Prime selon surface et zone climatique.',
                    ],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 4. CTA CONTACT ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA — Vérifier ma conformité',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Vérifiez votre conformité',
                'sous_titre' => 'Identifiez votre classe ISO 52120-1, évaluez vos obligations BACS et estimez vos aides CEE. Échangeons sans engagement.',
                'bouton_texte' => 'Me contacter',
                'bouton_lien' => '/contact',
                'bouton2_texte' => 'Lancer le diagnostic',
                'bouton2_lien' => '/audit',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> ReglementationPageSeeder : {$order} bricks créées.");
    }
}
