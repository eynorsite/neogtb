<?php

namespace Database\Seeders;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

class EnrichPagesBricksSeeder extends Seeder
{
    public function run(): void
    {
        // === GTB — contenu complet ===
        $this->seedPage('gtb', [
            ['type' => 'hero', 'name' => 'Hero GTB', 'content' => [
                'badge' => '📘 Guide éducatif',
                'titre' => 'Qu\'est-ce que la GTB ?',
                'sous_titre' => 'La Gestion Technique du Bâtiment est le cerveau intelligent qui pilote, supervise et optimise l\'ensemble des équipements techniques d\'un bâtiment.',
                'cta_texte' => 'Évaluer mon bâtiment',
                'cta_lien' => '/audit',
                'cta2_texte' => 'GTB vs GTC →',
                'cta2_lien' => '/gtc',
            ], 'settings' => ['hauteur' => 'medium', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Définition de la GTB', 'content' => [
                'titre' => 'Définition de la GTB',
                'contenu' => '<p>La <strong>Gestion Technique du Bâtiment (GTB)</strong>, aussi appelée <em>Building Management System (BMS)</em> en anglais, est un système informatique centralisé qui permet de <strong>superviser, piloter et optimiser</strong> l\'ensemble des équipements techniques d\'un bâtiment.</p><p>Elle agit comme le <strong>système nerveux central</strong> du bâtiment en collectant les données de milliers de capteurs, en les analysant et en envoyant des commandes aux équipements pour maintenir le confort tout en minimisant la consommation énergétique.</p><p>📋 <strong>Réglementation :</strong> La GTB est obligatoire dans les bâtiments tertiaires de plus de 1 000 m² depuis le <strong>décret BACS (2020)</strong>, dans le cadre du décret tertiaire.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'chiffres', 'name' => 'La GTB en chiffres', 'content' => [
                'titre' => 'La GTB en chiffres',
                'stats' => [
                    ['icone' => '📉', 'valeur' => '40', 'suffixe' => '%', 'label' => 'd\'économies d\'énergie'],
                    ['icone' => '📅', 'valeur' => '3', 'suffixe' => ' ans', 'label' => 'retour sur investissement'],
                    ['icone' => '🔧', 'valeur' => '30', 'suffixe' => '%', 'label' => 'de maintenance en moins'],
                ],
            ], 'settings' => ['couleur_fond' => '#f8fafc', 'animation' => true]],

            ['type' => 'cartes', 'name' => 'Les 6 fonctions principales', 'content' => [
                'titre_section' => 'Les 6 fonctions principales de la GTB',
                'cartes' => [
                    ['icone' => '🌡️', 'titre' => 'CVC', 'description' => 'Chauffage, Ventilation et Climatisation. Régulation de la température, qualité de l\'air, gestion des centrales de traitement d\'air.', 'lien' => ''],
                    ['icone' => '💡', 'titre' => 'Éclairage', 'description' => 'Gestion intelligente : détection de présence, variation d\'intensité, scénarios lumineux, gestion horaire.', 'lien' => ''],
                    ['icone' => '⚡', 'titre' => 'Énergie', 'description' => 'Comptage énergétique, suivi des consommations, détection des dérives, optimisation tarifaire et délestage.', 'lien' => ''],
                    ['icone' => '🔐', 'titre' => 'Sécurité', 'description' => 'Contrôle d\'accès, détection d\'intrusion, vidéosurveillance, sécurité incendie et alarmes techniques.', 'lien' => ''],
                    ['icone' => '🤖', 'titre' => 'Automatisation', 'description' => 'Scénarios automatiques, programmation horaire, gestion des modes (occupation, inoccupation, vacances).', 'lien' => ''],
                    ['icone' => '📊', 'titre' => 'Reporting', 'description' => 'Tableaux de bord, historiques, rapports automatisés, indicateurs de performance et alertes.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cartes', 'name' => 'Les 4 niveaux de GTB', 'content' => [
                'titre_section' => 'Les 4 niveaux de GTB (norme EN 15232)',
                'cartes' => [
                    ['icone' => '🔴', 'titre' => 'Classe D — Non performant', 'description' => 'Aucun système de gestion. Équipements manuels sans automatisation. 0% d\'économies.', 'lien' => ''],
                    ['icone' => '🟠', 'titre' => 'Classe C — Standard', 'description' => 'Automatisation de base. Régulation simple, programmation horaire. 10-15% d\'économies.', 'lien' => ''],
                    ['icone' => '🟢', 'titre' => 'Classe B — Avancé', 'description' => 'GTB centralisée. Supervision complète, suivi énergétique détaillé. 20-30% d\'économies.', 'lien' => ''],
                    ['icone' => '🔵', 'titre' => 'Classe A — Haute performance', 'description' => 'GTB intelligente. Optimisation prédictive, IA, auto-apprentissage. 30-50% d\'économies.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 2]],

            ['type' => 'cartes', 'name' => 'Architecture GTB', 'content' => [
                'titre_section' => 'Architecture d\'un système GTB',
                'cartes' => [
                    ['icone' => '🖥️', 'titre' => 'Niveau Gestion — Supervision', 'description' => 'Logiciel de supervision (SCADA), base de données, interface web, reporting et historiques.', 'lien' => ''],
                    ['icone' => '⚙️', 'titre' => 'Niveau Automatisme — Contrôleurs', 'description' => 'Automates programmables (PLC), contrôleurs de zone, régulateurs. Communication BACnet, Modbus, KNX.', 'lien' => ''],
                    ['icone' => '📡', 'titre' => 'Niveau Terrain — Capteurs', 'description' => 'Sondes de température, détecteurs de présence, vannes, variateurs. Les organes sensoriels du bâtiment.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cta', 'name' => 'CTA GTB', 'content' => [
                'titre' => 'Évaluez le niveau GTB de votre bâtiment',
                'sous_titre' => 'Notre diagnostic gratuit identifie votre classe actuelle (EN 15232) et les axes d\'amélioration.',
                'bouton_texte' => 'Lancer le diagnostic',
                'bouton_lien' => '/audit',
                'bouton2_texte' => 'Découvrir la GTC →',
                'bouton2_lien' => '/gtc',
            ], 'settings' => ['style' => 'dark']],
        ]);

        // === GTC — contenu complet ===
        $this->seedPage('gtc', [
            ['type' => 'hero', 'name' => 'Hero GTC', 'content' => [
                'badge' => '📗 Guide éducatif',
                'titre' => 'Qu\'est-ce que la GTC ?',
                'sous_titre' => 'La Gestion Technique Centralisée est le système de supervision qui centralise la surveillance et le contrôle de tous les équipements sur une interface unique.',
                'cta_texte' => 'Évaluer mon bâtiment',
                'cta_lien' => '/audit',
                'cta2_texte' => 'GTB vs GTC →',
                'cta2_lien' => '/gtb',
            ], 'settings' => ['hauteur' => 'medium', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Définition GTC', 'content' => [
                'titre' => 'Définition de la GTC',
                'contenu' => '<p>La <strong>Gestion Technique Centralisée (GTC)</strong> est un système informatique qui permet de centraliser la supervision de l\'ensemble des lots techniques d\'un bâtiment ou d\'un parc immobilier sur une <strong>seule interface</strong>.</p><p>Contrairement à la GTB qui se concentre sur un bâtiment unique, la GTC peut <strong>superviser plusieurs bâtiments simultanément</strong>, offrant une vision globale à l\'exploitant.</p><p>Elle collecte en temps réel les données des différents systèmes (CVC, éclairage, sécurité, énergie), les affiche sur des <strong>synoptiques graphiques</strong> et permet de piloter les équipements à distance.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'cartes', 'name' => 'Fonctions clés GTC', 'content' => [
                'titre_section' => 'Les fonctions clés de la GTC',
                'cartes' => [
                    ['icone' => '🖥️', 'titre' => 'Supervision en temps réel', 'description' => 'Visualisation de tous les états et mesures sur des synoptiques interactifs.', 'lien' => ''],
                    ['icone' => '🚨', 'titre' => 'Gestion des alarmes', 'description' => 'Détection automatique des anomalies, alertes et historique des événements.', 'lien' => ''],
                    ['icone' => '📱', 'titre' => 'Pilotage à distance', 'description' => 'Commande des équipements depuis un poste central ou un appareil mobile.', 'lien' => ''],
                    ['icone' => '📈', 'titre' => 'Historisation & Reporting', 'description' => 'Archivage des données, courbes de tendance, rapports automatisés.', 'lien' => ''],
                    ['icone' => '🏢', 'titre' => 'Multi-sites', 'description' => 'Supervision de plusieurs bâtiments depuis une plateforme centralisée.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'comparatif', 'name' => 'GTB vs GTC', 'content' => [
                'titre' => 'GTB vs GTC : quelles différences ?',
                'sous_titre' => 'En pratique, les termes sont souvent utilisés de manière interchangeable. L\'important est de comprendre que la GTC supervise tandis que la GTB supervise ET pilote.',
                'colonne_gauche_titre' => 'GTB (Building Management)',
                'colonne_droite_titre' => 'GTC (Supervision Centralisée)',
                'lignes_gauche' => [
                    ['texte' => '1 bâtiment, tous les lots techniques'],
                    ['texte' => 'Fonction : piloter et optimiser'],
                    ['texte' => 'Régulation intégrée (automates)'],
                    ['texte' => 'Plus complexe, plus puissante'],
                    ['texte' => 'Utilisateur : technicien maintenance'],
                ],
                'lignes_droite' => [
                    ['texte' => 'Plusieurs bâtiments ou 1 lot technique'],
                    ['texte' => 'Fonction : superviser et centraliser'],
                    ['texte' => 'Lecture seule ou commandes simples'],
                    ['texte' => 'Plus simple, interface de supervision'],
                    ['texte' => 'Utilisateur : gestionnaire technique'],
                ],
            ], 'settings' => []],

            ['type' => 'cartes', 'name' => 'Composants GTC', 'content' => [
                'titre_section' => 'Les composants d\'une GTC',
                'cartes' => [
                    ['icone' => '🖥️', 'titre' => 'Poste de supervision', 'description' => 'Interface graphique avec synoptiques, courbes, alarmes. Accessible depuis un navigateur web.', 'lien' => ''],
                    ['icone' => '🌐', 'titre' => 'Réseau de communication', 'description' => 'Infrastructure réseau (IP, BACnet, Modbus) reliant les automates au serveur. Filaire ou sans fil.', 'lien' => ''],
                    ['icone' => '💾', 'titre' => 'Serveur & Base de données', 'description' => 'Stockage des historiques, gestion des utilisateurs, moteur de règles et rapports automatiques.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cta', 'name' => 'CTA GTC', 'content' => [
                'titre' => 'Besoin d\'évaluer votre système de supervision ?',
                'sous_titre' => 'Notre audit gratuit analyse votre installation GTB/GTC et identifie les optimisations possibles.',
                'bouton_texte' => 'Lancer l\'audit gratuit',
                'bouton_lien' => '/audit',
                'bouton2_texte' => 'Découvrir la GTB →',
                'bouton2_lien' => '/gtb',
            ], 'settings' => ['style' => 'dark']],
        ]);

        // === SOLUTIONS — contenu complet ===
        $this->seedPage('solutions', [
            ['type' => 'hero', 'name' => 'Hero Solutions', 'content' => [
                'badge' => '🔧 Technologies',
                'titre' => 'Solutions & Technologies',
                'sous_titre' => 'Les protocoles de communication, capteurs, automates et logiciels qui composent un système GTB/GTC moderne.',
                'cta_texte' => 'Comparer les marques',
                'cta_lien' => '/comparateur',
            ], 'settings' => ['hauteur' => 'compact', 'alignement' => 'center']],

            ['type' => 'cartes', 'name' => 'Protocoles de communication', 'content' => [
                'titre_section' => 'Les protocoles de communication',
                'cartes' => [
                    ['icone' => '🌐', 'titre' => 'BACnet', 'description' => 'Protocole standard international (ISO 16484-5) pour la GTB. Indépendant des constructeurs, il permet l\'interopérabilité entre équipements de marques différentes.', 'lien' => ''],
                    ['icone' => '🏠', 'titre' => 'KNX', 'description' => 'Protocole européen standardisé (EN 50090) pour l\'automatisation du bâtiment. Très utilisé pour l\'éclairage, les stores et le CVC.', 'lien' => ''],
                    ['icone' => '⚙️', 'titre' => 'Modbus', 'description' => 'Protocole industriel simple et robuste. Existe en version série (RS-485) et réseau (TCP/IP). Idéal pour les compteurs et équipements industriels.', 'lien' => ''],
                    ['icone' => '🔗', 'titre' => 'LonWorks', 'description' => 'Réseau de contrôle distribué par Echelon. Chaque nœud possède sa propre intelligence. Utilisé dans les grandes installations.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 2]],

            ['type' => 'cartes', 'name' => 'Capteurs & Actionneurs', 'content' => [
                'titre_section' => 'Capteurs & Actionneurs',
                'cartes' => [
                    ['icone' => '🌡️', 'titre' => 'Sondes de température', 'description' => 'Mesure ambiante, gaine, extérieure, contact, immersion.', 'lien' => ''],
                    ['icone' => '👁️', 'titre' => 'Détecteurs de présence', 'description' => 'PIR, ultrasons, double technologie pour l\'éclairage et le CVC.', 'lien' => ''],
                    ['icone' => '⚡', 'titre' => 'Compteurs d\'énergie', 'description' => 'Électricité, gaz, eau, calories — suivi en temps réel.', 'lien' => ''],
                    ['icone' => '🔄', 'titre' => 'Vannes & Actionneurs', 'description' => 'Vannes 2/3 voies, registres, variateurs de vitesse.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 4]],

            ['type' => 'cartes', 'name' => 'Tendances & Innovations', 'content' => [
                'titre_section' => 'Tendances & Innovations',
                'cartes' => [
                    ['icone' => '📡', 'titre' => 'IoT & Capteurs connectés', 'description' => 'Les capteurs sans fil (LoRaWAN, Zigbee, EnOcean) révolutionnent l\'installation et permettent un maillage dense à moindre coût.', 'lien' => ''],
                    ['icone' => '🧠', 'titre' => 'Intelligence Artificielle', 'description' => 'L\'IA optimise la régulation en temps réel, prédit les pannes et adapte le fonctionnement aux usages réels.', 'lien' => ''],
                    ['icone' => '🏗️', 'titre' => 'Jumeaux numériques', 'description' => 'La réplique virtuelle du bâtiment permet de simuler des scénarios, optimiser les systèmes et former les équipes.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cta', 'name' => 'CTA Solutions', 'content' => [
                'titre' => 'Quelle solution pour votre bâtiment ?',
                'sous_titre' => 'Notre audit gratuit analyse vos besoins et vous recommande les technologies adaptées.',
                'bouton_texte' => 'Lancer l\'audit gratuit',
                'bouton_lien' => '/audit',
            ], 'settings' => ['style' => 'dark']],
        ]);

        // === À PROPOS — contenu complet ===
        $this->seedPage('about', [
            ['type' => 'hero', 'name' => 'Hero À Propos', 'content' => [
                'badge' => 'ℹ️ Qui sommes-nous',
                'titre' => 'À Propos de NéoGTB',
                'sous_titre' => 'Le tiers de confiance indépendant de la GTB en France. Nous ne vendons rien — nous vous aidons à décider.',
                'cta_texte' => 'Nous contacter',
                'cta_lien' => '/contact',
            ], 'settings' => ['hauteur' => 'compact', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Notre mission', 'content' => [
                'titre' => 'Notre mission',
                'contenu' => '<p>La GTB est un levier puissant pour réduire la consommation énergétique des bâtiments. Pourtant, elle reste mal connue et chaque acteur du marché vous oriente vers ses propres produits.</p><p><strong>NéoGTB</strong> est né d\'un constat simple : il n\'existait aucun <strong>tiers de confiance indépendant</strong> capable de vous accompagner dans vos choix GTB sans conflit d\'intérêts.</p><p>Notre mission : être le partenaire objectif qui vous aide à <strong>comprendre, comparer et décider</strong> en connaissance de cause.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'cartes', 'name' => 'Nos valeurs', 'content' => [
                'titre_section' => 'Nos valeurs',
                'cartes' => [
                    ['icone' => '🎓', 'titre' => 'Pédagogie', 'description' => 'Vulgariser les concepts techniques sans trahir la rigueur. Seul un vrai expert peut simplifier sans simplisme.', 'lien' => ''],
                    ['icone' => '🌍', 'titre' => 'Transition écologique', 'description' => 'La GTB est un levier majeur de décarbonation. Chaque bâtiment optimisé est une victoire pour le climat.', 'lien' => ''],
                    ['icone' => '🎯', 'titre' => 'Indépendance', 'description' => 'Contenus neutres et objectifs. Nous ne vendons pas, ne représentons personne, prescrivons ce qui est adapté.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 3]],

            ['type' => 'cartes', 'name' => 'À qui s\'adresse NéoGTB', 'content' => [
                'titre_section' => 'À qui s\'adresse NéoGTB ?',
                'cartes' => [
                    ['icone' => '🏢', 'titre' => 'Gestionnaires de patrimoine', 'description' => 'Optimisez la gestion énergétique et le confort de vos bâtiments.', 'lien' => ''],
                    ['icone' => '🔧', 'titre' => 'Installateurs & Intégrateurs', 'description' => 'Restez à jour sur les technologies et les bonnes pratiques.', 'lien' => ''],
                    ['icone' => '📐', 'titre' => 'Bureaux d\'études', 'description' => 'Ressources techniques pour vos projets de conception GTB.', 'lien' => ''],
                    ['icone' => '🎓', 'titre' => 'Étudiants & Curieux', 'description' => 'Découvrez le monde passionnant du smart building.', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 4]],

            ['type' => 'texte', 'name' => 'Fondateur', 'content' => [
                'titre' => 'Qui est derrière NéoGTB ?',
                'contenu' => '<p><strong>Ulrich CALMO</strong> — Fondateur & gérant, EYNOR</p><p>Passionné par la GTB et la performance énergétique des bâtiments, j\'ai créé NéoGTB pour offrir enfin un espace indépendant où décideurs, techniciens et curieux peuvent accéder à une information fiable, sans pression commerciale.</p><p>📍 Eysines, Bordeaux — 🏢 EYNOR</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#f8fafc']],

            ['type' => 'cta', 'name' => 'CTA About', 'content' => [
                'titre' => 'Prêt à explorer la GTB ?',
                'sous_titre' => 'Commencez par nos guides éducatifs ou lancez un diagnostic gratuit de votre bâtiment.',
                'bouton_texte' => 'Découvrir la GTB',
                'bouton_lien' => '/gtb',
                'bouton2_texte' => 'Lire le blog',
                'bouton2_lien' => '/blog',
            ], 'settings' => ['style' => 'dark']],
        ]);

        // === CONTACT — enrichi ===
        $this->seedPage('contact', [
            ['type' => 'hero', 'name' => 'Hero Contact', 'content' => [
                'badge' => '📞 Réponse sous 48h',
                'titre' => 'Besoin d\'un avis indépendant ?',
                'sous_titre' => 'Posez votre question à notre équipe. Réponse factuelle, sans agenda commercial.',
            ], 'settings' => ['hauteur' => 'compact', 'alignement' => 'center']],

            ['type' => 'texte', 'name' => 'Formulaire info', 'content' => [
                'titre' => 'Envoyez-nous un message',
                'contenu' => '<p>Contactez-nous directement par email à <strong>contact@neogtb.fr</strong> ou utilisez le formulaire de notre site.</p><p>Nous nous engageons à répondre sous <strong>48 heures ouvrées</strong>. NéoGTB est un tiers de confiance indépendant : aucune démarche commerciale suite à votre contact.</p>',
            ], 'settings' => ['position_image' => 'none', 'couleur_fond' => '#ffffff']],

            ['type' => 'cartes', 'name' => 'Coordonnées', 'content' => [
                'titre_section' => '',
                'cartes' => [
                    ['icone' => '📧', 'titre' => 'Email', 'description' => 'contact@neogtb.fr', 'lien' => 'mailto:contact@neogtb.fr'],
                    ['icone' => '📍', 'titre' => 'Localisation', 'description' => 'Eysines, Bordeaux — France', 'lien' => ''],
                    ['icone' => '🏢', 'titre' => 'Entreprise', 'description' => 'EYNOR', 'lien' => ''],
                    ['icone' => '⏱️', 'titre' => 'Temps de réponse', 'description' => 'Sous 48h ouvrées, sans démarche commerciale', 'lien' => ''],
                ],
            ], 'settings' => ['colonnes' => 4]],

            ['type' => 'cta', 'name' => 'CTA Diagnostic', 'content' => [
                'titre' => 'Préférez un diagnostic en ligne ?',
                'sous_titre' => 'Évaluez la maturité GTB de votre bâtiment en 5 minutes — résultat immédiat.',
                'bouton_texte' => 'Lancer le diagnostic gratuit',
                'bouton_lien' => '/audit',
            ], 'settings' => ['style' => 'dark']],
        ]);
    }

    private function seedPage(string $slug, array $bricks): void
    {
        $page = SitePage::where('slug', $slug)->first();
        if (!$page) {
            $this->command->warn("Page '{$slug}' not found");
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
            ]);
        }

        $this->command->info("=> {$page->name}: {$order} bricks");
    }
}
