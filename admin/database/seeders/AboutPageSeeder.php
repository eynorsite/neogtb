<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * AboutPageSeeder — seed la page À propos à partir du contenu
 * actuel de resources/views/front/about.blade.php.
 */
class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'about')->first();
        if (!$page) {
            $this->command->error('Page About introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page About supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — À propos d\'Ulrich Calmo',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'À propos',
                'pre_titre' => 'NeoGTB',
                'titre' => 'Je suis Ulrich Calmo, et j\'ai créé NeoGTB pour une raison simple',
                'description' => 'Le marché de la GTB en France manque d\'un interlocuteur neutre. Quelqu\'un qui ne vend rien, qui connaît le terrain, et qui vous aide à prendre la bonne décision. C\'est ce que je fais.',
                'image' => '/images/hero-about.png',
                'image_alt' => 'Consultant indépendant GTB au centre des bâtiments',
            ],
            'settings' => ['hauteur' => 'min-420', 'overlay' => 'soft-bottom', 'alignement' => 'left'],
        ]);

        // === 2. FONDATEUR ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'fondateur',
            'brick_name' => 'Fondateur — Ulrich Calmo',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Pourquoi j\'ai créé NeoGTB',
                'titre' => 'Un regard technique, sans conflit d\'intérêts',
                'texte' => 'En travaillant sur des projets GTB, j\'ai constaté que les décideurs n\'ont personne vers qui se tourner pour un avis neutre. Chaque interlocuteur vend sa solution. J\'ai créé NeoGTB pour combler ce vide : éduquer le marché, fournir des outils d\'analyse indépendants, et permettre à chaque professionnel de décider en connaissance de cause. NeoGTB est une marque de ma société EYNOR, basée à Eysines près de Bordeaux.',
                'photo' => '/images/ulrich-calmo.webp',
                'photo_alt' => 'Ulrich Calmo, créateur de la marque NeoGTB',
                'nom' => 'Ulrich Calmo',
                'role' => 'Fondateur de NeoGTB',
                'identite' => [
                    'EYNOR — Eysines, près de Bordeaux',
                    'GTB / GTC / Supervision bâtiment',
                    'Protocoles : BACnet, KNX, Modbus, LON',
                    'Réglementation : décret BACS, tertiaire',
                    'Audit énergétique & AMO GTB',
                ],
                'modele_economique' => [
                    ['titre' => 'Conseil payant', 'description' => 'Audits sur site, cahiers des charges neutres, AMO GTB.'],
                    ['titre' => 'Outils gratuits', 'description' => 'Diagnostic, comparateur, CEE — sans inscription, sans relance.'],
                    ['titre' => 'Zéro commission', 'description' => 'Aucun fabricant ne me rémunère, directement ou indirectement.'],
                ],
                'stats' => [
                    ['valeur' => '10+', 'label' => 'technologies analysées'],
                    ['valeur' => '41', 'label' => 'protocoles référencés'],
                    ['valeur' => '0 €', 'label' => 'commission fabricant'],
                    ['valeur' => '100 %', 'label' => 'indépendant'],
                ],
                'cta_texte' => 'Voir mon profil LinkedIn',
                'cta_lien' => 'https://www.linkedin.com/in/ulrich-calmo/',
            ],
            'settings' => [],
        ]);

        // === 3. CARTES VALEURS / CHARTE ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes',
            'brick_name' => 'Cartes — Charte d\'indépendance',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Mes valeurs',
                'titre_section' => 'Ma charte d\'indépendance',
                'sous_titre' => 'Cinq engagements concrets, vérifiables, sans exception.',
                'cartes' => [
                    [
                        'icone' => 'check',
                        'titre' => 'Aucun lien commercial',
                        'description' => 'Pas de partenariat, d\'affiliation ou de sponsoring avec un fabricant GTB. Jamais.',
                    ],
                    [
                        'icone' => 'check',
                        'titre' => 'Aucune commission',
                        'description' => 'Je ne touche rien sur les ventes, prescriptions ou orientations. Mon revenu vient du conseil facturé.',
                    ],
                    [
                        'icone' => 'check',
                        'titre' => 'Méthodologie publique',
                        'description' => 'Mes critères d\'évaluation sont transparents et vérifiables sur le site.',
                    ],
                    [
                        'icone' => 'check',
                        'titre' => 'Vos données restent privées',
                        'description' => 'Aucune donnée de diagnostic n\'est revendue, partagée ou transmise à des tiers.',
                    ],
                    [
                        'icone' => 'check',
                        'titre' => 'Correction ouverte',
                        'description' => 'En cas d\'erreur factuelle, correction publique et rapide. Toujours.',
                    ],
                    [
                        'icone' => 'check',
                        'titre' => 'Méthode 4 phases',
                        'description' => 'État des lieux, analyse comparative, recommandations, accompagnement. Reproductible.',
                    ],
                ],
            ],
            'settings' => ['colonnes' => 3, 'fond' => 'dark-50'],
        ]);

        // === 4. CTA ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA — Un projet GTB à clarifier',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Un projet GTB à clarifier ?',
                'sous_titre' => 'Échangeons sur votre situation. Sans engagement, sans pression commerciale.',
                'bouton_texte' => 'Me contacter directement',
                'bouton_lien' => '/contact',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> AboutPageSeeder : {$order} bricks créées.");
    }
}
