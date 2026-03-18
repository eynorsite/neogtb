<?php

namespace Database\Seeders;

use App\Models\SitePage;
use Illuminate\Database\Seeder;

class SitePagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'accueil',
                'name' => 'Accueil',
                'hero_title' => 'Maîtrisez la Gestion Technique de vos Bâtiments',
                'hero_subtitle' => 'Guides complets, outils et conseils d\'experts',
                'hero_description' => 'NeoGTB vous accompagne dans la compréhension et l\'optimisation de votre GTB/GTC. Audit gratuit, comparateurs de solutions et articles techniques.',
                'hero_cta_text' => 'Audit GTB gratuit',
                'hero_cta_url' => '/audit',
                'meta_title' => 'Accueil - Gestion Technique du Bâtiment',
                'meta_description' => 'NeoGTB - Tout savoir sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC). Guides, audits gratuits et comparateurs.',
                'order' => 1,
            ],
            [
                'slug' => 'gtb',
                'name' => 'Qu\'est-ce que la GTB ?',
                'hero_title' => 'Qu\'est-ce que la GTB ?',
                'hero_subtitle' => 'Guide complet de la Gestion Technique du Bâtiment',
                'hero_description' => 'Découvrez comment la GTB permet de piloter, superviser et optimiser l\'ensemble des équipements techniques d\'un bâtiment.',
                'hero_cta_text' => 'Faire un audit GTB',
                'hero_cta_url' => '/audit',
                'meta_title' => 'Qu\'est-ce que la GTB ? Guide complet',
                'meta_description' => 'La GTB (Gestion Technique du Bâtiment) permet de superviser et piloter tous les équipements techniques. Guide complet avec niveaux EN 15232.',
                'order' => 2,
            ],
            [
                'slug' => 'gtc',
                'name' => 'Qu\'est-ce que la GTC ?',
                'hero_title' => 'Qu\'est-ce que la GTC ?',
                'hero_subtitle' => 'Guide complet de la Gestion Technique Centralisée',
                'hero_description' => 'Comprenez la GTC, son rôle dans la supervision des installations techniques et ses différences avec la GTB.',
                'hero_cta_text' => 'Comparer GTB vs GTC',
                'hero_cta_url' => '/gtb',
                'meta_title' => 'Qu\'est-ce que la GTC ? Guide complet',
                'meta_description' => 'La GTC (Gestion Technique Centralisée) centralise la supervision des équipements techniques d\'un bâtiment.',
                'order' => 3,
            ],
            [
                'slug' => 'solutions',
                'name' => 'Solutions & Technologies',
                'hero_title' => 'Solutions & Technologies GTB/GTC',
                'hero_subtitle' => 'Protocoles, capteurs et innovations',
                'hero_description' => 'Explorez les technologies qui font fonctionner la GTB : BACnet, KNX, Modbus, IoT et intelligence artificielle.',
                'hero_cta_text' => 'Comparer les marques',
                'hero_cta_url' => '/comparateur',
                'meta_title' => 'Solutions & Technologies GTB/GTC',
                'meta_description' => 'Découvrez les protocoles (BACnet, KNX, Modbus), capteurs et innovations qui font fonctionner la GTB/GTC moderne.',
                'order' => 4,
            ],
            [
                'slug' => 'audit',
                'name' => 'Audit GTB Gratuit',
                'hero_title' => 'Audit GTB Gratuit',
                'hero_subtitle' => 'Évaluez le niveau de performance de votre bâtiment',
                'hero_description' => 'Répondez à 8 questions pour obtenir votre score GTB selon la norme EN 15232 et des recommandations personnalisées.',
                'hero_cta_text' => 'Commencer l\'audit',
                'hero_cta_url' => '#audit-form',
                'meta_title' => 'Audit GTB Gratuit en ligne',
                'meta_description' => 'Évaluez gratuitement le niveau de performance GTB de votre bâtiment. Score EN 15232 et recommandations personnalisées.',
                'order' => 5,
            ],
            [
                'slug' => 'comparateur',
                'name' => 'Comparateur de marques',
                'hero_title' => 'Comparateur de marques GTB/GTC',
                'hero_subtitle' => 'Trouvez la solution adaptée à votre projet',
                'hero_description' => 'Comparez les principales marques du marché GTB/GTC : Schneider Electric, Siemens, Honeywell, Johnson Controls et bien d\'autres.',
                'hero_cta_text' => 'Voir le comparatif',
                'hero_cta_url' => '#comparateur',
                'meta_title' => 'Comparateur de marques GTB/GTC',
                'meta_description' => 'Comparez les principales marques GTB/GTC : Schneider Electric, Siemens, Honeywell, Johnson Controls. Notes, prix, protocoles.',
                'order' => 6,
            ],
            [
                'slug' => 'contact',
                'name' => 'Contact',
                'hero_title' => 'Contactez-nous',
                'hero_subtitle' => 'Une question sur la GTB/GTC ?',
                'hero_description' => 'Notre équipe est à votre disposition pour répondre à vos questions et vous accompagner dans vos projets.',
                'meta_title' => 'Contact - NeoGTB',
                'meta_description' => 'Contactez l\'équipe NeoGTB pour toute question sur la GTB, la GTC ou pour demander un audit personnalisé.',
                'order' => 7,
            ],
            [
                'slug' => 'about',
                'name' => 'À Propos',
                'hero_title' => 'À Propos de NeoGTB',
                'hero_subtitle' => 'Notre mission : rendre la GTB accessible à tous',
                'hero_description' => 'NeoGTB est une plateforme éducative indépendante dédiée à la Gestion Technique du Bâtiment.',
                'meta_title' => 'À Propos - NeoGTB',
                'meta_description' => 'NeoGTB est une plateforme éducative indépendante sur la GTB/GTC. Contenu gratuit, vérifié par des experts, en français.',
                'order' => 8,
            ],
        ];

        foreach ($pages as $page) {
            SitePage::firstOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, ['is_published' => true])
            );
        }

        $this->command->info(count($pages) . ' pages du site injectées.');
    }
}
