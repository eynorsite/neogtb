<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * HomePageSeeder — seed la page d'accueil à partir du contenu actuel
 * de resources/views/front/accueil.blade.php (audit phase 2 NeoGTB).
 *
 * Crée 10 bricks correspondant aux sections existantes de la page d'accueil.
 * Les types "methodologie", "timeline", "cas-usage", "fondateur" sont des
 * extensions futures qui n'ont pas encore de blade renderer dans views/front/bricks/
 * mais leur contenu est seedé pour pouvoir être édité depuis l'admin Filament.
 */
class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'accueil')->first();
        if (!$page) {
            $this->command->error('Page Accueil introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Accueil supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero-image',
            'brick_name' => 'Hero — Décret BACS 2030',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Décret BACS 2030 · Êtes-vous en conformité ?',
                'pre_titre' => 'NéoGTB',
                'titre' => 'Votre bâtiment consomme trop. On vous montre où et pourquoi.',
                'description' => 'Pré-diagnostic ISO 52120-1 gratuit, comparateur de solutions sans biais commercial. Les gestionnaires qui nous consultent identifient en moyenne 23 % d\'économies CVC sur des bureaux passant de classe D à B.',
                'image' => '/images/hero-neogtb.webp',
                'image_alt' => 'Salle de contrôle NéoGTB — supervision technique du bâtiment',
                'cta_texte' => 'Évaluer mon bâtiment',
                'cta_lien' => '/audit',
                'cta2_texte' => 'Comparer les solutions GTB',
                'cta2_lien' => '/comparateur',
                'stats' => [
                    ['valeur' => '23 %', 'label' => "d'économies CVC en moyenne (bureaux, D→B)"],
                    ['valeur' => '10+', 'label' => 'fabricants évalués sans lien commercial'],
                    ['valeur' => '0 €', 'label' => 'commission — jamais'],
                ],
            ],
            'settings' => ['hauteur' => 'min-520', 'overlay' => 'gradient-left', 'alignement' => 'right'],
        ]);

        // === 2. IMPACT BAR ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'chiffres',
            'brick_name' => 'Impact bar — 4 chiffres clés',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'stats' => [
                    ['valeur' => 'Classe B min.', 'label' => 'exigence décret BACS (ISO 52120-1)'],
                    ['valeur' => '8+', 'label' => 'protocoles couverts (BACnet, KNX, Modbus, DALI…)'],
                    ['valeur' => '0 €', 'label' => 'commission fabricant'],
                    ['valeur' => '100 %', 'label' => 'indépendant — aucun lien fabricant'],
                ],
            ],
            'settings' => ['style' => 'inline-bar', 'colonnes' => 4],
        ]);

        // === 3. POSITIONING — 3 outils ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes-positioning',
            'brick_name' => 'Positioning — Trois outils pour éclairer vos décisions',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Ce que nous faisons',
                'titre_section' => 'Trois outils pour éclairer vos décisions GTB',
                'sous_titre' => 'Gratuit, sans engagement, sans orientation commerciale vers une marque ou un protocole.',
                'cartes' => [
                    [
                        'icone' => 'gauge',
                        'titre' => 'Pré-diagnostic : évaluez la maturité de votre bâtiment',
                        'description' => 'Auto-évaluation en 8 questions basée sur la norme ISO 52120-1. Score immédiat, recommandations par niveau A à D.',
                        'preview' => 'gauge-en15232',
                        'lien' => '/audit',
                        'cta_texte' => 'Lancer le pré-diagnostic →',
                    ],
                    [
                        'icone' => 'bars',
                        'titre' => 'Comparez les technologies sans biais',
                        'description' => '10 fabricants GTB analysés sur des critères objectifs : protocoles, ouverture, coût, scalabilité.',
                        'preview' => 'comparateur-bars',
                        'lien' => '/comparateur',
                        'cta_texte' => 'Comparer les marques →',
                    ],
                    [
                        'icone' => 'document',
                        'titre' => 'Estimez vos aides CEE en 3 minutes',
                        'description' => 'Calcul basé sur les fiches BAT-TH-116 et BAT-TH-112. Estimation indépendante, sans intermédiaire.',
                        'preview' => 'estimation-cee',
                        'preview_data' => ['valeur' => '12 400 €', 'contexte' => 'pour 5 000 m² tertiaire', 'maj' => 'Barèmes CEE mis à jour : avril 2026'],
                        'lien' => '/generateur-cee',
                        'cta_texte' => 'Estimer mes CEE →',
                    ],
                ],
                'cta_inline_texte' => 'Vous ne savez pas par où commencer ?',
                'cta_inline_lien_texte' => 'Lancer le pré-diagnostic gratuit →',
                'cta_inline_lien' => '/audit',
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 4. METHODOLOGY — 4 étapes ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'methodologie',
            'brick_name' => 'Méthodologie — 4 phases NeoGTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Notre approche',
                'titre' => 'La méthode NeoGTB — 4 phases',
                'sous_titre' => 'Une approche structurée et reproductible, calibrée sur les exigences du décret BACS et de la norme EN ISO 52120-1.',
                'etapes' => [
                    ['numero' => 1, 'icone' => 'search', 'titre' => 'État des lieux', 'description' => 'Cartographie équipements, protocoles, niveau ISO 52120-1', 'active' => false],
                    ['numero' => 2, 'icone' => 'bars', 'titre' => 'Analyse comparative', 'description' => 'Solutions du marché : taille, protocoles, budget, contraintes', 'active' => false],
                    ['numero' => 3, 'icone' => 'check', 'titre' => 'Recommandations', 'description' => 'ROI chiffré, gains énergétiques, calendrier BACS', 'active' => true],
                    ['numero' => 4, 'icone' => 'bolt', 'titre' => 'Accompagnement', 'description' => 'Suivi mise en œuvre, vérification, transfert compétences', 'active' => false],
                ],
                'cta_texte' => 'Discuter de mon projet →',
                'cta_lien' => '/contact',
            ],
            'settings' => ['fond' => 'dark-50'],
        ]);

        // === 5. FONDATEUR ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'fondateur',
            'brick_name' => 'Fondateur — Ulrich Calmo',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Qui est derrière NeoGTB',
                'titre' => 'Je ne suis pas un commercial GTB.<br />Je suis le conseil que j\'aurais voulu trouver.',
                'texte' => 'J\'ai créé la marque NeoGTB parce que ceux qui vous conseillent en GTB sont les mêmes qui vous vendent. NeoGTB comble ce vide : l\'analyse, le benchmark et la méthodologie — sans représenter aucun fabricant.',
                'photo' => '/images/ulrich-calmo.webp',
                'photo_alt' => 'Ulrich Calmo, créateur de la marque NeoGTB',
                'nom' => 'Ulrich Calmo',
                'role' => 'Créateur de la marque NeoGTB',
                'identite' => [
                    'Basé à Eysines, près de Bordeaux',
                    'EYNOR — structure indépendante',
                    'Spécialiste GTB & efficacité énergétique',
                    '+15 ans en CVC/énergie tertiaire',
                    'Ex-directeur général, formateur habilité',
                ],
                'modele_economique' => [
                    ['titre' => 'Conseil payant', 'description' => 'Audits sur site, cahiers des charges, AMO GTB.'],
                    ['titre' => 'Outils gratuits', 'description' => 'Diagnostic, comparateur, CEE. Sans piège ni relance.'],
                    ['titre' => 'Zéro commission', 'description' => 'Aucun fabricant ne me rémunère. Jamais.'],
                ],
                'cta_texte' => 'En savoir plus sur mon parcours →',
                'cta_lien' => '/about',
            ],
            'settings' => [],
        ]);

        // === 6. TIMELINE RÉGLEMENTAIRE ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'timeline',
            'brick_name' => 'Timeline réglementaire — BACS & Décret tertiaire',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Échéances réglementaires',
                'eyebrow_color' => 'energy',
                'titre' => 'Décret BACS & Décret Tertiaire — le calendrier qui vous concerne',
                'points' => [
                    ['annee' => '2025', 'label' => 'BACS classe B min.', 'detail' => 'Puissance CVC > 290 kW', 'etat' => 'present'],
                    ['annee' => '2030', 'label' => 'BACS classe B min.', 'detail' => 'Puissance CVC 70-290 kW', 'etat' => 'futur'],
                    ['annee' => '2040', 'label' => 'Décret tertiaire', 'detail' => '-50 % conso', 'etat' => 'futur'],
                    ['annee' => '2050', 'label' => 'Décret tertiaire', 'detail' => '-60 % conso', 'etat' => 'futur'],
                ],
                'legende' => [
                    ['couleur' => 'energy', 'texte' => 'En vigueur'],
                    ['couleur' => 'accent', 'texte' => 'À venir'],
                ],
            ],
            'settings' => ['fond' => 'white-bordered'],
        ]);

        // === 7. CASE STUDIES ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cas-usage',
            'brick_name' => 'Cas d\'usage — 2 retours d\'expérience',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Cas d\'usage',
                'titre' => 'Des situations concrètes, des résultats mesurables',
                'cas' => [
                    [
                        'tag' => 'Décret BACS',
                        'tag_variant' => 'reglementation',
                        'meta' => 'Tertiaire · 12 000 m²',
                        'titre' => 'Mise en conformité BACS d\'un ensemble de bureaux multi-sites',
                        'contexte' => 'Un gestionnaire de 3 sites tertiaires devait se conformer au décret BACS. Aucune GTB en place, systèmes CVC hétérogènes.',
                        'approche' => 'Audit ISO 52120-1 sur 3 sites, benchmark 4 solutions multi-protocoles, estimation CEE, cahier des charges neutre.',
                        'gauge' => ['progress_from' => 'C', 'active' => 'B', 'label' => 'Progression ISO 52120-1'],
                        'metriques' => [
                            ['valeur' => '-23 %', 'label' => 'conso CVC', 'couleur' => 'energy'],
                            ['valeur' => '45 j', 'label' => 'cahier des charges', 'couleur' => 'dark'],
                        ],
                    ],
                    [
                        'tag' => 'Rénovation CVC',
                        'tag_variant' => 'technique',
                        'meta' => 'Enseignement · 8 500 m²',
                        'titre' => 'Optimisation énergétique d\'un campus universitaire vieillissant',
                        'contexte' => 'Un campus équipé d\'une GTC obsolète (LON). Consommation supérieure de 40 % à la moyenne du secteur éducatif.',
                        'approche' => 'Diagnostic complet, plan de migration progressive LON → BACnet IP sur 24 mois (par lot technique), comparaison de 3 superviseurs, simulation des gains.',
                        'gauge' => ['progress_from' => 'D', 'active' => 'B', 'label' => 'Objectif ISO 52120-1'],
                        'metriques' => [
                            ['valeur' => '-35 %', 'label' => 'objectif réduction', 'couleur' => 'energy'],
                            ['valeur' => '3 ans', 'label' => 'ROI estimé', 'couleur' => 'dark'],
                        ],
                    ],
                ],
                'cta_texte' => 'Lancer le pré-diagnostic pour votre bâtiment →',
                'cta_lien' => '/audit',
            ],
            'settings' => ['colonnes' => 2],
        ]);

        // === 8. INSIGHTS — 3 articles blog ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes-articles',
            'brick_name' => 'Insights — 3 articles blog',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Perspectives',
                'titre_section' => 'Analyses & veille technique',
                'cta_haut_texte' => 'Tous les articles →',
                'cta_haut_lien' => '/blog',
                'cartes' => [
                    [
                        'tag' => 'Réglementation',
                        'tag_variant' => 'reglementation',
                        'titre' => 'Décret tertiaire et GTB : obligations et mise en conformité',
                        'duree' => '8 min de lecture',
                        'lien' => '/blog/decret-tertiaire-gtb-obligations',
                    ],
                    [
                        'tag' => 'Protocoles',
                        'tag_variant' => 'protocoles',
                        'titre' => 'BACnet, KNX, Modbus : quel protocole pour quel usage en GTB ?',
                        'duree' => '6 min de lecture',
                        'lien' => '/blog/protocoles-communication-bacnet-knx-modbus',
                    ],
                    [
                        'tag' => 'Guide',
                        'tag_variant' => 'gtb',
                        'titre' => 'Qu\'est-ce que la GTB ? Le guide complet 2026',
                        'duree' => '5 min de lecture',
                        'lien' => '/blog/guide-complet-gtb-2026',
                    ],
                ],
            ],
            'settings' => ['colonnes' => 3, 'fond' => 'dark-50', 'style' => 'article-card'],
        ]);

        // === 9. COMPTEUR + CTA HONNÊTE ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-counter',
            'brick_name' => 'Compteur d\'usage + CTA honnête',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Depuis le lancement',
                'compteurs' => [
                    ['valeur' => '340+', 'label' => 'diagnostics réalisés', 'couleur' => 'dark'],
                    ['valeur' => '1 200+', 'label' => 'comparaisons lancées', 'couleur' => 'dark'],
                    ['valeur' => '2,4 M€', 'label' => 'CEE estimés via l\'outil', 'couleur' => 'energy'],
                    ['valeur' => '0 €', 'label' => 'commission fabricant', 'couleur' => 'accent'],
                ],
                'titre' => 'NeoGTB est un projet récent. Pas de faux témoignages ici.',
                'sous_titre' => 'Plutôt que d\'inventer des avis, je vous propose de tester les outils vous-même. Le pré-diagnostic prend 3 minutes. Si l\'approche vous parle, on en discute.',
                'note' => 'Les premiers retours clients seront publiés ici dès qu\'ils seront vérifiables.',
                'bouton_texte' => 'Tester le pré-diagnostic gratuit',
                'bouton_lien' => '/audit',
                'bouton2_texte' => 'Échanger avec moi',
                'bouton2_lien' => '/contact',
            ],
            'settings' => ['style' => 'honest-cta'],
        ]);

        // === 10. CTA FINAL ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA final — Regard indépendant',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Un regard indépendant sur votre GTB',
                'sous_titre' => 'Pré-diagnostic gratuit, sans engagement, sans orientation commerciale.',
                'bouton_texte' => 'Lancer le pré-diagnostic',
                'bouton_lien' => '/audit',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> HomePageSeeder : {$order} bricks créées pour la page Accueil.");
    }
}
