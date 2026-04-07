<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

/**
 * PositionnementPageSeeder — seed la page Positionnement à partir du contenu
 * actuel de resources/views/front/positionnement.blade.php.
 */
class PositionnementPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = SitePage::where('slug', 'positionnement')->first();
        if (!$page) {
            $this->command->error('Page Positionnement introuvable. Lance d\'abord SitePagesSeeder.');
            return;
        }

        $page->bricks()->delete();
        $this->command->info('Anciens bricks de la page Positionnement supprimés.');

        $order = 0;

        // === 1. HERO ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero',
            'brick_name' => 'Hero — Pourquoi NeoGTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'badge' => 'Pourquoi nous',
                'titre' => 'Vous cherchez un conseil GTB qui ne cherche pas à vous vendre quelque chose',
                'description' => 'Sur le marché français, celui qui conseille est souvent celui qui vend. NeoGTB est né pour offrir l\'alternative : un regard technique, sans conflit d\'intérêts.',
            ],
            'settings' => ['fond' => 'gradient-light'],
        ]);

        // === 2. CHIFFRES — preuves d'indépendance ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'chiffres',
            'brick_name' => 'Preuves en chiffres',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'stats' => [
                    ['valeur' => '0 €', 'label' => 'commission fabricant depuis la création'],
                    ['valeur' => '0', 'label' => 'lien d\'affiliation sur le site'],
                    ['valeur' => '10+', 'label' => 'fabricants évalués sur critères identiques'],
                    ['valeur' => '100 %', 'label' => 'du revenu vient du conseil, pas de la vente'],
                ],
            ],
            'settings' => ['style' => 'inline-bar', 'colonnes' => 4, 'fond' => 'dark-50'],
        ]);

        // === 3. CARTES DIFFÉRENCIATION — 3 colonnes ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cartes-positioning',
            'brick_name' => 'Différenciation — Ce qu\'on fait / pas / pourquoi',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Transparence',
                'titre_section' => 'Comment NeoGTB gagne (et ne gagne pas) de l\'argent',
                'sous_titre' => 'Un site gratuit qui ne vend rien — voici le modèle, en clair.',
                'cartes' => [
                    [
                        'icone' => 'check',
                        'titre' => 'Ce que NeoGTB fait',
                        'description' => 'Vend du conseil technique facturé : audits sur site, cahiers des charges neutres, AMO GTB. Comme un bureau d\'études indépendant.',
                        'liste' => [
                            'Audits ISO 52120-1 sur site',
                            'Cahiers des charges neutres',
                            'AMO GTB et accompagnement',
                            'Outils gratuits, sans inscription',
                        ],
                    ],
                    [
                        'icone' => 'cross',
                        'titre' => 'Ce que NeoGTB ne fait pas',
                        'description' => 'Aucune revente de matériel, aucune commission, aucune transmission de données. Les outils gratuits ne sont pas un produit d\'appel.',
                        'liste' => [
                            'Revendre vos données de diagnostic',
                            'Transmettre vos coordonnées à des tiers',
                            'Toucher des commissions fournisseurs',
                            'Utiliser les outils comme produit d\'appel caché',
                        ],
                    ],
                    [
                        'icone' => 'bolt',
                        'titre' => 'Pourquoi ce modèle',
                        'description' => 'Parce qu\'un conseil libre de conflit d\'intérêts est la seule manière d\'aider vraiment les décideurs à choisir la bonne GTB.',
                        'liste' => [
                            'Recommandations techniques, pas commerciales',
                            'Critères de comparaison publics',
                            'Indépendance vérifiable',
                            'Engagement de long terme',
                        ],
                    ],
                ],
            ],
            'settings' => ['colonnes' => 3],
        ]);

        // === 4. COMPARATIF — Intégrateur classique vs NeoGTB ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'comparatif',
            'brick_name' => 'Comparatif — Intégrateur classique vs NeoGTB',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'eyebrow' => 'Vérifiez vous-même',
                'titre' => 'Comment savoir si un conseil GTB est vraiment indépendant',
                'sous_titre' => 'Quatre questions simples pour démasquer un faux conseil neutre.',
                'colonnes' => [
                    ['label' => 'Question à poser'],
                    ['label' => 'Intégrateur classique'],
                    ['label' => 'NeoGTB', 'highlight' => true],
                ],
                'lignes' => [
                    ['Vendez-vous du matériel ?', 'Oui', 'Non'],
                    ['Commission sur les ventes ?', 'Souvent', '0 €, toujours'],
                    ['Critères de comparaison publics ?', 'Rarement', 'Oui, sur le site'],
                    ['Outils accessibles sans inscription ?', 'Non', 'Oui, 3 outils gratuits'],
                ],
            ],
            'settings' => ['fond' => 'dark-50'],
        ]);

        // === 5. CTA ===
        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta-illustrated',
            'brick_name' => 'CTA — Testez l\'approche',
            'order' => $order++,
            'is_visible' => true,
            'content' => [
                'titre' => 'Testez l\'approche',
                'sous_titre' => 'Pré-diagnostic ISO 52120-1 gratuit, comparateur sans biais, générateur CEE. Aucune inscription requise.',
                'bouton_texte' => 'Diagnostic gratuit',
                'bouton_lien' => '/audit',
                'bouton2_texte' => 'Prendre contact',
                'bouton2_lien' => '/contact',
                'image_fond' => '/images/hero-gtb-illustration.webp',
            ],
            'settings' => ['style' => 'illustrated', 'fond' => '#F0F2F5'],
        ]);

        $this->command->info("=> PositionnementPageSeeder : {$order} bricks créées.");
    }
}
