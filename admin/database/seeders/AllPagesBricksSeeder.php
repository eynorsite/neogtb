<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

class AllPagesBricksSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPage('gtb', [
            ['type' => 'hero', 'name' => 'Hero GTB', 'content' => [
                'badge' => '📘 Guide éducatif',
                'titre' => 'Qu\'est-ce que la GTB ?',
                'sous_titre' => 'La Gestion Technique du Bâtiment est le cerveau intelligent qui pilote, supervise et optimise l\'ensemble des équipements techniques.',
                'description' => '',
                'cta_texte' => 'Évaluer mon bâtiment',
                'cta_lien' => '/audit',
                'cta2_texte' => 'GTB vs GTC →',
                'cta2_lien' => '/gtc',
            ], 'settings' => ['hauteur' => 'medium', 'overlay' => 40, 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Définition de la GTB', 'content' => [
                'titre' => 'Définition de la GTB',
                'contenu' => '<p>La <strong>Gestion Technique du Bâtiment (GTB)</strong>, aussi appelée Building Management System (BMS), est un système informatique qui permet de <strong>superviser, piloter et optimiser</strong> l\'ensemble des équipements techniques d\'un bâtiment.</p><p>Elle couvre les domaines du <strong>chauffage, climatisation, ventilation (CVC)</strong>, de l\'<strong>éclairage</strong>, des <strong>contrôles d\'accès</strong>, de la <strong>détection incendie</strong>, et des <strong>comptages énergétiques</strong>.</p>',
                'image' => null,
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'chiffres', 'name' => 'La GTB en chiffres', 'content' => [
                'titre' => 'La GTB en chiffres',
                'sous_titre' => '',
                'stats' => [
                    ['icone' => '📉', 'valeur' => '40', 'suffixe' => '%', 'label' => 'd\'économies d\'énergie'],
                    ['icone' => '🏢', 'valeur' => '30', 'suffixe' => '%', 'label' => 'de retour sur investissement'],
                    ['icone' => '🌱', 'valeur' => '35', 'suffixe' => '%', 'label' => 'de réduction CO2'],
                ],
            ], 'settings' => ['couleur_fond' => '#f8fafc', 'animation' => true]],

            ['type' => 'cartes', 'name' => 'Fonctions principales', 'content' => [
                'titre_section' => 'Les fonctions principales de la GTB',
                'cartes' => [
                    ['icone' => '🌡️', 'titre' => 'Régulation CVC', 'description' => 'Pilotage automatique du chauffage, de la ventilation et de la climatisation.', 'lien' => ''],
                    ['icone' => '💡', 'titre' => 'Gestion de l\'éclairage', 'description' => 'Détection de présence, variation d\'intensité, scénarios lumineux.', 'lien' => ''],
                    ['icone' => '⚡', 'titre' => 'Suivi énergétique', 'description' => 'Comptage chauffage, éclairage, prises et détection des dérives automatique.', 'lien' => ''],
                    ['icone' => '🔐', 'titre' => 'Sécurité', 'description' => 'Contrôle d\'accès, détection d\'intrusion, sécurité incendie.', 'lien' => ''],
                    ['icone' => '📊', 'titre' => 'Reporting', 'description' => 'Tableaux de bord, historiques, rapports automatisés pour le décret tertiaire.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cta', 'name' => 'CTA GTB', 'content' => [
                'titre' => 'Évaluez le niveau GTB de votre bâtiment',
                'sous_titre' => 'Notre diagnostic gratuit évalue votre niveau actuel et vous propose des recommandations.',
                'bouton_texte' => 'Lancer le diagnostic',
                'bouton_lien' => '/audit',
                'bouton2_texte' => 'Découvrez la GTC →',
                'bouton2_lien' => '/gtc',
            ], 'settings' => ['style' => 'dark']],
        ]);

        $this->seedPage('gtc', [
            ['type' => 'hero', 'name' => 'Hero GTC', 'content' => [
                'badge' => '📗 Guide éducatif',
                'titre' => 'Qu\'est-ce que la GTC ?',
                'sous_titre' => 'La Gestion Technique Centralisée est le poste de contrôle central qui supervise l\'ensemble des systèmes techniques depuis un point unique.',
                'cta_texte' => 'Évaluer mon bâtiment',
                'cta_lien' => '/audit',
                'cta2_texte' => 'GTB vs GTC →',
                'cta2_lien' => '/gtb',
            ], 'settings' => ['hauteur' => 'medium', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Définition GTC', 'content' => [
                'titre' => 'Définition de la GTC',
                'contenu' => '<p>La <strong>Gestion Technique Centralisée (GTC)</strong> est un système qui centralise la supervision de tous les équipements techniques d\'un bâtiment sur un <strong>poste de contrôle unique</strong>.</p><p>Elle permet de visualiser en temps réel l\'état de chaque installation, de recevoir les <strong>alarmes</strong>, de consulter les <strong>historiques</strong> et de piloter les équipements à distance.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'cartes', 'name' => 'Fonctions GTC', 'content' => [
                'titre_section' => 'Les fonctions clés de la GTC',
                'cartes' => [
                    ['icone' => '🖥️', 'titre' => 'Supervision centralisée', 'description' => 'Vue d\'ensemble de tous les équipements depuis un poste unique.', 'lien' => ''],
                    ['icone' => '🚨', 'titre' => 'Gestion des alarmes', 'description' => 'Remontée et acquittement des alarmes en temps réel.', 'lien' => ''],
                    ['icone' => '📈', 'titre' => 'Historiques & courbes', 'description' => 'Enregistrement et analyse des données sur le long terme.', 'lien' => ''],
                    ['icone' => '🔧', 'titre' => 'Maintenance préventive', 'description' => 'Planification des interventions basée sur les données.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 2]],

            ['type' => 'cta', 'name' => 'CTA GTC', 'content' => [
                'titre' => 'Besoin d\'un système GTC adapté ?',
                'sous_titre' => 'Notre diagnostic gratuit vous aide à identifier la solution la plus adaptée à votre bâtiment.',
                'bouton_texte' => 'Diagnostic gratuit',
                'bouton_lien' => '/audit',
                'bouton2_texte' => '',
                'bouton2_lien' => '',
            ], 'settings' => ['style' => 'dark']],
        ]);

        $this->seedPage('solutions', [
            ['type' => 'hero', 'name' => 'Hero Solutions', 'content' => [
                'badge' => '🔧 Technologies',
                'titre' => 'Solutions & Technologies',
                'sous_titre' => 'Les protocoles de communication, capteurs, automates et logiciels qui composent un système GTB/GTC moderne.',
                'cta_texte' => 'Comparer les marques',
                'cta_lien' => '/comparateur',
            ], 'settings' => ['hauteur' => 'compact', 'alignement' => 'center']],

            ['type' => 'cartes', 'name' => 'Protocoles', 'content' => [
                'titre_section' => 'Les protocoles de communication',
                'cartes' => [
                    ['icone' => '🌐', 'titre' => 'BACnet', 'description' => 'Protocole ouvert international ISO 16484-5 pour la GTB. Interopérabilité entre les équipements de différents fabricants.', 'lien' => ''],
                    ['icone' => '🏠', 'titre' => 'KNX', 'description' => 'Protocole européen compatible EN 50090 pour l\'automatisation du bâtiment. Très utilisé pour l\'éclairage et le CVC.', 'lien' => ''],
                    ['icone' => '⚙️', 'titre' => 'Modbus', 'description' => 'Protocole industriel simple et robuste. Existe en version série RS-485 et réseau TCP/IP.', 'lien' => ''],
                    ['icone' => '🔗', 'titre' => 'LonWorks', 'description' => 'Réseau de contrôle distribué conçu par Echelon. Chaque noeud possède sa propre intelligence.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 2]],

            ['type' => 'cartes', 'name' => 'Capteurs', 'content' => [
                'titre_section' => 'Capteurs & Actionneurs',
                'cartes' => [
                    ['icone' => '🌡️', 'titre' => 'Sondes de température', 'description' => 'Mesure ambiante, gaine, extérieure, contact.', 'lien' => ''],
                    ['icone' => '👁️', 'titre' => 'Détecteurs de présence', 'description' => 'PIR, ultrasons, double technologie.', 'lien' => ''],
                    ['icone' => '⚡', 'titre' => 'Compteurs d\'énergie', 'description' => 'Électrique, thermique, gaz, eau.', 'lien' => ''],
                    ['icone' => '🔄', 'titre' => 'Vannes & Actionneurs', 'description' => 'Vannes modulantes, registres, variateurs de vitesse.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 4]],

            ['type' => 'cta', 'name' => 'CTA Solutions', 'content' => [
                'titre' => 'Quelle solution pour votre bâtiment ?',
                'sous_titre' => 'Notre audit gratuit analyse vos besoins et vous recommande les technologies adaptées.',
                'bouton_texte' => 'Lancer l\'audit gratuit',
                'bouton_lien' => '/audit',
            ], 'settings' => ['style' => 'dark']],
        ]);

        $this->seedPage('contact', [
            ['type' => 'hero', 'name' => 'Hero Contact', 'content' => [
                'badge' => '📞 Répondez-nous vite',
                'titre' => 'Besoin d\'un avis indépendant ?',
                'sous_titre' => 'Posez votre question à notre équipe. Réponse factuelle, sans agenda commercial.',
                'cta_texte' => '',
                'cta_lien' => '',
            ], 'settings' => ['hauteur' => 'compact', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Formulaire info', 'content' => [
                'titre' => 'Envoyez-nous un message',
                'contenu' => '<p>Remplissez le formulaire ci-dessous ou contactez-nous directement par email à <strong>hello@neogtb.fr</strong>.</p><p>Nous nous engageons à répondre sous <strong>48 heures ouvrées</strong>. NéoGTB est un tiers de confiance indépendant : aucune démarche commerciale suite à votre contact.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'cartes', 'name' => 'Infos contact', 'content' => [
                'titre_section' => '',
                'cartes' => [
                    ['icone' => '📧', 'titre' => 'Email', 'description' => 'hello@neogtb.fr', 'lien' => 'mailto:hello@neogtb.fr'],
                    ['icone' => '📍', 'titre' => 'Localisation', 'description' => 'France — 100% digital', 'lien' => ''],
                    ['icone' => '⏱️', 'titre' => 'Temps de réponse', 'description' => 'Sous 48h ouvrées', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],
        ]);

        $this->seedPage('about', [
            ['type' => 'hero', 'name' => 'Hero À Propos', 'content' => [
                'badge' => 'ℹ️ Qui sommes-nous',
                'titre' => 'À Propos de NéoGTB',
                'sous_titre' => 'Le tiers de confiance indépendant de la GTB en France.',
                'cta_texte' => 'Nous contacter',
                'cta_lien' => '/contact',
            ], 'settings' => ['hauteur' => 'compact', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Notre mission', 'content' => [
                'titre' => 'Notre mission',
                'contenu' => '<p><strong>NéoGTB</strong> est né d\'un constat simple : dans le monde de la Gestion Technique du Bâtiment, les informations disponibles sont soit trop techniques, soit orientées par des intérêts commerciaux.</p><p>Notre mission est d\'offrir un <strong>accès libre et objectif</strong> à l\'information sur la GTB/GTC, pour que chaque gestionnaire de bâtiment puisse prendre des décisions éclairées.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'cartes', 'name' => 'Nos valeurs', 'content' => [
                'titre_section' => 'Nos valeurs',
                'cartes' => [
                    ['icone' => '🎯', 'titre' => 'Indépendance', 'description' => 'Aucun lien commercial avec les fabricants. Nos recommandations sont 100% objectives.', 'lien' => ''],
                    ['icone' => '📖', 'titre' => 'Transparence', 'description' => 'Contenus gratuits, méthodologie ouverte, données sourcées.', 'lien' => ''],
                    ['icone' => '🤝', 'titre' => 'Accessibilité', 'description' => 'Rendre la GTB compréhensible pour tous, pas seulement les experts.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cta', 'name' => 'CTA About', 'content' => [
                'titre' => 'Un projet GTB ? Parlons-en.',
                'sous_titre' => 'Diagnostic gratuit, sans engagement, sans démarche commerciale.',
                'bouton_texte' => 'Nous contacter',
                'bouton_lien' => '/contact',
            ], 'settings' => ['style' => 'dark']],
        ]);

        $this->seedPage('audit', [
            ['type' => 'hero', 'name' => 'Hero Audit', 'content' => [
                'badge' => '🔍 Diagnostic gratuit',
                'titre' => 'Audit GTB Gratuit',
                'sous_titre' => 'Évaluez le niveau de maturité technique de votre bâtiment en 5 minutes.',
                'description' => 'Répondez à quelques questions et recevez un rapport personnalisé avec des recommandations concrètes.',
                'cta_texte' => 'Commencer le diagnostic',
                'cta_lien' => '#audit-form',
            ], 'settings' => ['hauteur' => 'medium', 'alignement' => 'center']],

            ['type' => 'cartes', 'name' => 'Ce que vous obtiendrez', 'content' => [
                'titre_section' => 'Ce que vous obtiendrez',
                'cartes' => [
                    ['icone' => '📊', 'titre' => 'Score de maturité', 'description' => 'Évaluation de votre niveau GTB sur une échelle de 1 à 4 (norme EN 15232).', 'lien' => ''],
                    ['icone' => '💡', 'titre' => 'Recommandations', 'description' => 'Actions concrètes pour améliorer la performance de votre bâtiment.', 'lien' => ''],
                    ['icone' => '💰', 'titre' => 'Estimation ROI', 'description' => 'Potentiel d\'économies d\'énergie et retour sur investissement estimé.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cta', 'name' => 'CTA Audit', 'content' => [
                'titre' => 'Prêt à évaluer votre bâtiment ?',
                'sous_titre' => 'Gratuit, sans engagement, résultat immédiat.',
                'bouton_texte' => 'Commencer maintenant',
                'bouton_lien' => '#audit-form',
            ], 'settings' => ['style' => 'dark']],
        ]);

        $this->seedPage('comparateur', [
            ['type' => 'hero', 'name' => 'Hero Comparateur', 'content' => [
                'badge' => '⚖️ Comparatif indépendant',
                'titre' => 'Comparateur de marques GTB/GTC',
                'sous_titre' => 'Comparez objectivement les principales marques du marché. Aucun partenariat commercial.',
                'cta_texte' => 'Voir le comparatif',
                'cta_lien' => '#comparateur',
            ], 'settings' => ['hauteur' => 'medium', 'alignement' => 'center']],

            ['type' => 'cartes', 'name' => 'Marques analysées', 'content' => [
                'titre_section' => 'Marques analysées',
                'cartes' => [
                    ['icone' => '🏭', 'titre' => 'Siemens', 'description' => 'Desigo CC, gamme complète BACnet/KNX, forte présence en France.', 'lien' => ''],
                    ['icone' => '🏭', 'titre' => 'Schneider Electric', 'description' => 'EcoStruxure Building, leader français, intégration IoT.', 'lien' => ''],
                    ['icone' => '🏭', 'titre' => 'Honeywell', 'description' => 'Niagara Framework, solution ouverte multi-protocoles.', 'lien' => ''],
                    ['icone' => '🏭', 'titre' => 'Sauter', 'description' => 'Spécialiste CVC, excellent rapport qualité/prix.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 2]],

            ['type' => 'cta', 'name' => 'CTA Comparateur', 'content' => [
                'titre' => 'Besoin d\'aide pour choisir ?',
                'sous_titre' => 'Notre diagnostic gratuit vous aide à identifier la marque la plus adaptée.',
                'bouton_texte' => 'Diagnostic gratuit',
                'bouton_lien' => '/audit',
            ], 'settings' => ['style' => 'dark']],
        ]);
    }

    private function seedPage(string $slug, array $bricks): void
    {
        $page = SitePage::where('slug', $slug)->first();
        if (!$page) {
            $this->command->warn("Page '{$slug}' not found, skipping");
            return;
        }

        $page->bricks()->delete();
        $order = 0;

        foreach ($bricks as $brick) {
            PageBrick::create([
                'page_id' => $page->id,
                'brick_type' => $brick['type'],
                'brick_name' => $brick['name'],
                'content' => $brick['content'],
                'settings' => $brick['settings'] ?? [],
                'order' => $order++,
                'is_visible' => true,
                'is_locked' => false,
            ]);
        }

        $this->command->info("=> {$page->name}: {$order} bricks créées.");
    }
}
