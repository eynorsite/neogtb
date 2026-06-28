<?php

namespace Database\Seeders;

use App\Models\ChatbotFaq;
use App\Models\ChatbotKnowledgeSnippet;
use App\Models\ChatbotSetting;
use Illuminate\Database\Seeder;

class ChatbotSeeder extends Seeder
{
    /**
     * Base de connaissances + FAQ du chatbot.
     *
     * Faits réglementaires ancrés sur la page /reglementation (source de vérité du site).
     * Décret BACS = seuil en PUISSANCE CVC (kW), jamais en surface (m²) ; le m² (> 1 000 m²)
     * relève du décret tertiaire. Toute évolution de ces chiffres doit d'abord être validée
     * sur /reglementation avant d'être répercutée ici et en base de prod.
     */
    public function run(): void
    {
        ChatbotSetting::current();

        // NON destructif (firstOrCreate) : ce seeder pose une base de référence sur une
        // base vierge et NE réécrit PAS les snippets/FAQ déjà présents — le contenu de prod
        // est édité via Filament et ne doit pas être écrasé par un db:seed (cf. memory
        // project_chatbot_contenu_en_base). La version précédente de ce seeder créait des
        // snippets désormais remplacés (titres différents, contenu erroné « 30/12/2025 »,
        // « jusqu'en 2027 ») ; s'ils existent encore sur une base de dev, les retirer à la main.

        $snippets = [
            [
                'title' => 'Décret BACS — seuils d\'obligation (en kW, jamais en m²)',
                'category' => 'Réglementation',
                'priority' => 100,
                'content' => "Le décret BACS (décret n° 2020-887 du 20 juillet 2020, modifié par le décret n° 2025-1343 du 26 décembre 2025) impose un système d'automatisation et de contrôle (GTB) dans les bâtiments tertiaires non résidentiels. Le seuil d'assujettissement est une PUISSANCE des systèmes techniques (CVC : chauffage, ventilation, climatisation), exprimée en kilowatts (kW). Ce n'est JAMAIS une surface en m².\n\nBâtiments existants :\n- Puissance supérieure à 290 kW : obligation EN VIGUEUR depuis le 1er janvier 2025.\n- Puissance de 70 à 290 kW : obligation reportée au 1er janvier 2030 (l'échéance initiale de 2027 a été repoussée par le décret du 26 décembre 2025).\n\nBâtiments neufs (à la construction) :\n- Puissance supérieure à 290 kW pour les permis déposés après le 21 juillet 2021.\n- Puissance supérieure à 70 kW pour les permis déposés après le 8 avril 2024.\n\nLe système installé doit atteindre au minimum la classe B de la norme NF EN ISO 52120-1 (ex-EN 15232) et faire l'objet d'une inspection régulière. À ne pas confondre avec le décret tertiaire, dont le seuil est une surface (plus de 1 000 m²).",
            ],
            [
                'title' => 'Décret tertiaire (Éco Énergie Tertiaire) — à distinguer du BACS',
                'category' => 'Réglementation',
                'priority' => 90,
                'content' => "Le décret tertiaire (dispositif Éco Énergie Tertiaire, issu de l'article 175 de la loi ELAN n° 2018-1021 du 23 novembre 2018) concerne les bâtiments tertiaires de plus de 1 000 m² (seuil en SURFACE). Il impose une réduction progressive de la consommation d'énergie finale par rapport à une année de référence postérieure à 2010 : -40 % en 2030, -50 % en 2040, -60 % en 2050. Les consommations se déclarent chaque année sur la plateforme OPERAT de l'ADEME (déclaration annuelle avant le 30 septembre).\n\nC'est un dispositif DISTINCT du décret BACS. Le décret tertiaire vise la performance (seuil en m², objectifs de réduction de consommation) ; le décret BACS vise l'équipement (seuil en kW, installation d'une GTB de classe B).",
            ],
            [
                'title' => 'Classes de performance GTB — norme NF EN ISO 52120-1 (ex-EN 15232)',
                'category' => 'Norme',
                'priority' => 80,
                'content' => "La norme NF EN ISO 52120-1 (qui remplace l'EN 15232) classe la performance des systèmes de GTB en quatre niveaux :\n- Classe D : aucune automatisation (non conforme).\n- Classe C : automatisation standard (conforme au décret BACS).\n- Classe B : automatisation avancée avec GTB centralisée, suivi énergétique et détection de dérives. C'est le niveau couramment visé et la condition de la prime CEE.\n- Classe A : haute performance, avec optimisation énergétique et gestion prédictive.\n\nLe décret BACS impose des fonctions (art. R. 175-3 du CCH), pas une classe : la classe C reste conforme au décret. Les classes A et B ouvrent droit à la prime CEE BAT-TH-116.",
            ],
            [
                'title' => 'GTB et GTC — définitions et protocoles',
                'category' => 'Technique',
                'priority' => 60,
                'content' => "La GTB (Gestion Technique du Bâtiment) est le système centralisé qui supervise, pilote et optimise les équipements techniques d'un bâtiment : chauffage, ventilation, climatisation (CVC), éclairage, stores, contrôle d'accès, comptage d'énergie. La GTC (Gestion Technique Centralisée) désigne la supervision centralisée d'un ou plusieurs lots ou sites : elle remonte l'information et permet le pilotage à distance, mais ne porte pas toujours la régulation fine des équipements, qui relève de la GTB ou des automates de terrain.\n\nProtocoles de communication courants : BACnet (standard des grands bâtiments tertiaires), KNX (éclairage et stores), Modbus (comptage d'énergie).",
            ],
            [
                'title' => 'Services et positionnement de NeoGTB',
                'category' => 'Services',
                'priority' => 50,
                'content' => "NeoGTB est un service de conseil INDÉPENDANT en GTB, porté par la société EYNOR (Eysines, près de Bordeaux). NeoGTB ne vend aucun équipement et ne perçoit aucune commission de fabricant : les revenus proviennent uniquement de prestations de conseil (audits sur site, cahiers des charges neutres, assistance à maîtrise d'ouvrage GTB).\n\nOutils gratuits sur le site :\n- Pré-diagnostic GTB en ligne (estimation de classe ISO 52120-1) : /audit\n- Comparateur de solutions GTB : /comparateur\n- Générateur de dossier CEE (fiche BAT-TH-116) : /generateur-cee\nPour un échange personnalisé : /contact.",
            ],
            [
                'title' => 'Aides CEE pour la GTB — fiche BAT-TH-116',
                'category' => 'Aides',
                'priority' => 40,
                'content' => "La principale aide pour installer une GTB est la prime CEE (Certificats d'Économies d'Énergie) via la fiche standardisée BAT-TH-116. Elle couvre l'installation d'un système de GTB de classe A ou B (NF EN ISO 52120-1) pour le pilotage du CVC dans un bâtiment tertiaire existant. Le montant dépend de la surface, de la zone climatique et de la classe atteinte ; l'installation doit être réalisée par un professionnel. NeoGTB ne perçoit aucune commission sur les CEE.",
            ],
        ];

        foreach ($snippets as $s) {
            ChatbotKnowledgeSnippet::firstOrCreate(
                ['title' => $s['title']],
                $s + ['is_active' => true]
            );
        }

        $faqs = [
            [
                'question' => 'Mon bâtiment est-il concerné par le décret BACS ?',
                'answer' => "Le décret BACS s'applique aux bâtiments tertiaires selon la PUISSANCE de leurs systèmes CVC (chauffage, ventilation, climatisation), exprimée en kW, et non selon leur surface. Pour un bâtiment existant : l'obligation est en vigueur depuis le 1er janvier 2025 au-delà de 290 kW, et s'appliquera au 1er janvier 2030 pour la tranche 70 à 290 kW. Pour vérifier votre cas, faites le pré-diagnostic gratuit sur /audit.",
                'category' => 'Réglementation',
                'show_as_suggestion' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Quelle échéance pour un bâtiment dont la puissance CVC est entre 70 et 290 kW ?',
                'answer' => "Pour les bâtiments tertiaires existants dont la puissance des systèmes CVC est comprise entre 70 et 290 kW, l'obligation d'installer une GTB s'applique au 1er janvier 2030. Cette échéance, initialement prévue en 2027, a été reportée par le décret n° 2025-1343 du 26 décembre 2025. Au-delà de 290 kW, l'obligation est en vigueur depuis le 1er janvier 2025.",
                'category' => 'Réglementation',
                'show_as_suggestion' => false,
                'sort_order' => 2,
            ],
            [
                'question' => 'Quelle différence entre GTB et GTC ?',
                'answer' => "La GTC (Gestion Technique Centralisée) assure la supervision centralisée : elle remonte l'information et permet le pilotage à distance d'un ou plusieurs lots ou sites. La GTB (Gestion Technique du Bâtiment) va plus loin : elle pilote et régule finement l'ensemble des lots techniques (CVC, éclairage, énergie, etc.). Le décret BACS impose un système d'automatisation et de contrôle atteignant au minimum la classe B (NF EN ISO 52120-1), ce qui correspond à une GTB.",
                'category' => 'Technique',
                'show_as_suggestion' => true,
                'sort_order' => 3,
            ],
            [
                'question' => 'Comment se déroule un audit NeoGTB ?',
                'answer' => "Tout commence par notre pré-diagnostic gratuit en ligne (/audit) : quelques minutes de questions pour obtenir une estimation de classe GTB et des économies potentielles. Ensuite, si vous le souhaitez, nous proposons un audit terrain personnalisé sur devis : visite des installations, analyse des protocoles, rédaction du cahier des charges, comparatif d'intégrateurs.",
                'category' => 'Services',
                'show_as_suggestion' => true,
                'sort_order' => 4,
            ],
            [
                'question' => 'Combien coûte un accompagnement NeoGTB ?',
                'answer' => "Le pré-diagnostic en ligne est gratuit. Pour un accompagnement personnalisé, le tarif dépend de la taille du bâtiment et du périmètre. Nous fournissons toujours un devis détaillé avant tout engagement. Demandez un devis sans engagement via /contact.",
                'category' => 'Services',
                'show_as_suggestion' => false,
                'sort_order' => 5,
            ],
            [
                'question' => 'Êtes-vous indépendant des fabricants ?',
                'answer' => "Oui, totalement. NeoGTB est un service de conseil indépendant : nous ne vendons aucun matériel ni logiciel et ne percevons aucune commission de revente ni de fabricant. C'est ce qui fonde notre rôle de tiers de confiance.",
                'category' => 'Services',
                'show_as_suggestion' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $f) {
            ChatbotFaq::firstOrCreate(
                ['question' => $f['question']],
                $f + ['is_active' => true]
            );
        }

        $this->command?->info('Chatbot : settings + ' . count($snippets) . ' snippets + ' . count($faqs) . ' FAQ initialisés.');
    }
}
