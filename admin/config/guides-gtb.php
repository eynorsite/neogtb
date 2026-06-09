<?php

/*
|--------------------------------------------------------------------------
| Pages-guides GEO (piliers) — NeoGTB
|--------------------------------------------------------------------------
|
| Pendant du système comparatif (config/comparatifs-gtb.php), mais pour des
| pages à tableau générique N colonnes (pas X vs Y). Une route + un contrôleur
| + une vue, pilotés par ce fichier. Chaque entrée = un slug => une config.
|
| Structure d'une entrée :
|   - eyebrow            : sur-titre (string)
|   - title              : H1 visible (string)
|   - meta_title         : balise <title> (string)
|   - meta_description   : meta description (string)
|   - lede               : réponse atomique mise en avant (string)
|   - tables             : array de tableaux ; chaque tableau =
|                          ['caption' => string,
|                           'headers' => [...],
|                           'rows'    => [[...], [...]]]
|                          (la 1re cellule de chaque row -> <th scope="row">)
|   - note               : (optionnel) string affichée sous les tableaux
|   - cards              : (optionnel) array de ['title','meta','description']
|   - faq                : [ ['question','answer'], ... ]
|
| RÈGLE : aucune donnée chiffrée/date/seuil/norme inventée. Données verbatim.
|
*/

return [

    'protocoles-gtb' => [
        'eyebrow'          => 'Protocoles · Communication GTB',
        'title'            => 'BACnet, KNX, Modbus, LON : quel protocole pour la GTB ?',
        'meta_title'       => 'BACnet, KNX, Modbus, LON : quel protocole pour la GTB ? | NeoGTB',
        'meta_description' => 'Comparatif des protocoles de la GTB : BACnet, KNX, Modbus, LON. Standards, médium et usages dominants pour bien choisir.',
        'lede'             => "Il n'existe pas un protocole unique : BACnet est le standard d'interopérabilité de la GTB tertiaire, KNX domine l'éclairage et le CVC du petit tertiaire, Modbus s'impose pour le comptage d'énergie, et LON équipe surtout le parc existant. Le bon choix dépend du lot technique et de l'écosystème.",

        'tables' => [
            [
                'caption' => 'Comparatif des principaux protocoles de communication de la GTB',
                'headers' => ['Protocole', 'Standard', 'Médium / catégorie', 'Usage dominant'],
                'rows'    => [
                    ['BACnet', 'ISO 16484-5 (ASHRAE 135)', 'IP et MS/TP (RS-485)', "Standard d'interopérabilité multi-marques de la GTB"],
                    ['KNX', 'EN 50090 / ISO-IEC 14543', 'Bus filaire TP (twisted pair)', 'Éclairage, stores et CVC (résidentiel et petit tertiaire)'],
                    ['Modbus', 'RTU / TCP', 'RS-485 et Ethernet', "Comptage d'énergie (maître-esclave), créé par Modicon en 1979"],
                    ['LON', 'EN 14908', 'Peer-to-peer', 'Parc existant, en déclin face à BACnet IP'],
                ],
            ],
        ],

        'cards' => [
            [
                'title'       => 'DALI / DALI-2',
                'meta'        => 'IEC 62386',
                'description' => "Standard dédié au pilotage de l'éclairage. Jusqu'à 64 appareils par ligne, adressage individuel et gradation fine.",
            ],
            [
                'title'       => 'MQTT & API REST',
                'meta'        => 'IoT / Cloud',
                'description' => "Protocoles issus du monde IT, de plus en plus présents en GTB pour l'interopérabilité cloud, les jumeaux numériques et l'hypervision multi-sites.",
            ],
        ],

        'faq' => [
            [
                'question' => 'Quel est le protocole standard de la GTB ?',
                'answer'   => "BACnet (ISO 16484-5), maintenu par l'ASHRAE, conçu pour l'interopérabilité entre équipements de marques différentes.",
            ],
            [
                'question' => 'Quel protocole pour le comptage d\'énergie ?',
                'answer'   => "Modbus : simple et robuste (architecture maître-esclave), il est dominant pour le comptage d'énergie.",
            ],
            [
                'question' => 'BACnet ou KNX ?',
                'answer'   => "BACnet pour l'interopérabilité de la GTB tertiaire multi-marques ; KNX pour l'éclairage, les stores et le CVC en résidentiel et petit tertiaire.",
            ],
            [
                'question' => 'Le LON est-il encore utilisé ?',
                'answer'   => 'Il reste présent dans le parc existant mais est en déclin face à BACnet IP.',
            ],
        ],
    ],

    'classes-en-15232' => [
        'eyebrow'          => 'Norme · EN 15232 / ISO 52120-1',
        'title'            => 'Les classes EN 15232 (ISO 52120-1) : A, B, C, D',
        'meta_title'       => 'Les classes EN 15232 (ISO 52120-1) : A, B, C, D | NeoGTB',
        'meta_description' => "Les 4 classes d'efficacité de la GTB selon EN 15232 / NF EN ISO 52120-1 : A, B, C, D. Définitions et gains énergétiques estimés.",
        'lede'             => "La norme EN 15232 (NF EN ISO 52120-1) classe l'efficacité de la GTB sur 4 niveaux, de D (aucune automatisation) à A (haute performance). Le décret BACS exige au minimum la classe B.",

        'tables' => [
            [
                'caption' => 'Les 4 classes de la norme EN 15232 / NF EN ISO 52120-1',
                'headers' => ['Classe', 'Niveau', 'Description', 'Gains estimés (vs classe D)'],
                'rows'    => [
                    ['A', 'Haute performance énergétique', 'GTB avec régulation individuelle, optimisation automatique, détection de défauts', '30 à 40 %'],
                    ['B', 'Avancé (exigé par le décret BACS)', 'GTB avec régulation automatique par zone, programmation horaire', '20 à 30 %'],
                    ['C', 'Standard', 'Régulation basique, pas d\'automatisation avancée', '10 à 15 %'],
                    ['D', 'Non énergie-efficace', 'Pas de GTB, régulation manuelle uniquement', '0 % (référence)'],
                ],
            ],
        ],

        'note' => "Selon la norme, le gain global estimé par passage depuis la classe D est d'environ 10 % (D→C), 25 % (D→B) et 35 % (D→A). Ces gains sont une estimation normée, à vérifier sur chaque projet avec un audit approfondi.",

        'faq' => [
            [
                'question' => 'Quelle classe de GTB exige le décret BACS ?',
                'answer'   => 'La classe B au minimum (norme EN 15232 / NF EN ISO 52120-1).',
            ],
            [
                'question' => 'Qu\'est-ce qu\'une GTB de classe A ?',
                'answer'   => "Une GTB avec régulation individuelle, optimisation automatique et détection des défauts ; gains énergétiques estimés de 30 à 40 % par rapport à une absence d'automatisation.",
            ],
            [
                'question' => 'Quels gains énergétiques attendre d\'une GTB ?',
                'answer'   => "De l'ordre de 10 à 15 % (classe C), 20 à 30 % (classe B) et 30 à 40 % (classe A) par rapport à la classe D, selon l'estimation normée, à confirmer par un audit.",
            ],
        ],
    ],

    'gtb-obligatoire-puissance' => [
        'eyebrow'          => 'Décret BACS · Obligation GTB',
        'title'            => 'À partir de quelle puissance la GTB est-elle obligatoire ?',
        'meta_title'       => 'À partir de quelle puissance la GTB est-elle obligatoire ? | NeoGTB',
        'meta_description' => 'Décret BACS : la GTB est obligatoire pour les bâtiments tertiaires selon la puissance CVC. Seuils 70 et 290 kW, échéances 2025 et 2030.',
        'lede'             => "Au titre du décret BACS, la GTB est obligatoire dans les bâtiments tertiaires équipés de systèmes CVC dont la puissance dépasse 290 kW (depuis le 1er janvier 2025) ou comprise entre 70 et 290 kW (au 1er janvier 2030). Le système doit atteindre au minimum la classe B (EN 15232 / NF EN ISO 52120-1).",

        'tables' => [
            [
                'caption' => 'Bâtiments tertiaires existants : seuils et échéances du décret BACS',
                'headers' => ['Puissance CVC', 'Échéance', 'Statut (mars 2026)'],
                'rows'    => [
                    ['Plus de 290 kW', '1er janvier 2025', 'En vigueur'],
                    ['70 à 290 kW', '1er janvier 2030', 'Reporté (initialement 2027)'],
                ],
            ],
            [
                'caption' => 'Bâtiments neufs : obligation à la construction',
                'headers' => ['Permis de construire', 'Puissance CVC', 'Échéance'],
                'rows'    => [
                    ['À partir du 21/07/2021', 'Plus de 290 kW', 'À la construction'],
                    ['À partir du 08/04/2024', 'Plus de 70 kW', 'À la construction'],
                ],
            ],
        ],

        'faq' => [
            [
                'question' => 'Quelle puissance déclenche l\'obligation d\'installer une GTB ?',
                'answer'   => 'Pour les bâtiments existants : plus de 290 kW de CVC depuis le 1er janvier 2025, et 70 à 290 kW à partir du 1er janvier 2030.',
            ],
            [
                'question' => 'Comment se calcule la puissance prise en compte ?',
                'answer'   => 'C\'est la puissance nominale utile cumulée des systèmes CVC (chauffage + climatisation), soit la somme de tous les générateurs du bâtiment.',
            ],
            [
                'question' => 'Quelle classe de GTB faut-il atteindre ?',
                'answer'   => 'La classe B au minimum, selon la norme EN 15232 / NF EN ISO 52120-1.',
            ],
            [
                'question' => 'Peut-on être exempté de l\'obligation ?',
                'answer'   => 'Une dérogation est possible si un audit démontre que le temps de retour sur investissement de la GTB dépasse 6 ans.',
            ],
            [
                'question' => 'Quelle est la référence réglementaire ?',
                'answer'   => 'Le décret n°2020-887 du 20 juillet 2020, modifié par le décret n°2025-1343 du 26 décembre 2025.',
            ],
        ],
    ],

];
