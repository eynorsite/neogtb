<?php

/*
|--------------------------------------------------------------------------
| Pages comparatives GEO — NeoGTB
|--------------------------------------------------------------------------
|
| Système config-driven (inspiré d'eynor) : une route + un contrôleur + une
| vue, pilotés par ce fichier. Chaque entrée = un slug => une configuration.
|
| Structure d'une entrée :
|   - eyebrow            : sur-titre (string)
|   - title              : H1 visible (string)
|   - meta_title         : balise <title> (string)
|   - meta_description   : meta description (string)
|   - lede               : réponse atomique mise en avant (string)
|   - a_label / b_label  : intitulés des 2 colonnes comparées (string)
|   - rows               : lignes du tableau [ ['label','a','b'], ... ]
|   - choose             : ['a' => ['title','items'[]], 'b' => ['title','items'[]]]
|   - faq                : [ ['question','answer'], ... ]
|
| RÈGLE : aucune donnée chiffrée/date/seuil inventée. Données verbatim.
|
*/

return [

    'gtb-vs-gtc' => [
        'eyebrow'          => 'GTB · GTC · Supervision du bâtiment',
        'title'            => 'GTB ou GTC : quelle différence ? | NeoGTB',
        'meta_title'       => 'GTB ou GTC : quelle différence ? | NeoGTB',
        'meta_description' => "GTB ou GTC : la GTB régule finement un bâtiment, la GTC supervise un parc. Tableau comparatif, périmètre, protocoles et cas d'usage.",
        'lede'             => "La GTB pilote et régule finement tous les lots techniques d'UN bâtiment ; la GTC supervise et centralise l'information de PLUSIEURS bâtiments ou d'un parc, sans assurer la régulation fine. En résumé : la GTB agit, la GTC surveille.",

        'a_label' => 'GTB',
        'b_label' => 'GTC',

        'rows' => [
            ['label' => 'Périmètre',   'a' => 'un bâtiment, tous lots confondus',      'b' => 'plusieurs bâtiments ou un parc'],
            ['label' => 'Fonction',    'a' => 'piloter, réguler et optimiser',         'b' => 'superviser, centraliser, alerter'],
            ['label' => 'Régulation',  'a' => "intégrée (boucles PID, lois d'eau)",    'b' => 'limitée (marche/arrêt)'],
            ['label' => 'Utilisateur', 'a' => 'technicien, energy manager',            'b' => 'gestionnaire de patrimoine'],
            ['label' => 'Protocoles',  'a' => 'BACnet, LON, KNX',                      'b' => 'BACnet/IP, Modbus TCP, OPC-UA'],
            ['label' => 'Équivalent',  'a' => 'BMS (Building Management System)',      'b' => 'SCADA / BCS'],
        ],

        'choose' => [
            'a' => [
                'title' => 'Choisir la GTB si…',
                'items' => [
                    'Vous gérez un seul bâtiment, tous lots confondus',
                    "Vous devez réguler finement le CVC, l'éclairage, les stores",
                    'Vous visez une classe EN 15232 / la conformité au décret BACS',
                ],
            ],
            'b' => [
                'title' => 'Choisir la GTC si…',
                'items' => [
                    'Vous gérez un parc ou plusieurs sites',
                    'Vous voulez centraliser la supervision et les alarmes',
                    'La régulation fine est assurée localement par des automates ou une GTB par site',
                ],
            ],
        ],

        'faq' => [
            [
                'question' => 'GTB et GTC, est-ce la même chose ?',
                'answer'   => "Non. La GTB pilote et régule les équipements d'un bâtiment ; la GTC supervise et centralise l'information de plusieurs sites ou d'un parc. Elles sont complémentaires.",
            ],
            [
                'question' => 'La GTC remplace-t-elle la GTB ?',
                'answer'   => "Non. La GTC supervise et centralise, mais ne porte pas la régulation fine : c'est le rôle de la GTB ou des automates de terrain.",
            ],
            [
                'question' => 'Quel système pour le décret BACS ?',
                'answer'   => "C'est la GTB qui répond au décret BACS. Le décret impose des fonctions (art. R. 175-3), pas une classe ; la classe B (EN 15232 / NF EN ISO 52120-1) est le niveau couramment visé et la condition de la prime CEE.",
            ],
            [
                'question' => 'GTB est-elle l\'équivalent du BMS ?',
                'answer'   => 'Oui. BMS (Building Management System) est le terme anglophone équivalent à la GTB. La GTC correspond davantage à un SCADA / BCS.',
            ],
        ],
    ],

    'decret-bacs-vs-decret-tertiaire' => [
        'eyebrow'          => 'Réglementation · Bâtiments tertiaires',
        'title'            => 'Décret BACS ou décret tertiaire : quelle différence ? | NeoGTB',
        'meta_title'       => 'Décret BACS ou décret tertiaire : quelle différence ? | NeoGTB',
        'meta_description' => "Décret BACS vs décret tertiaire : l'un impose d'équiper en GTB selon la puissance CVC, l'autre un objectif de réduction d'énergie. Seuils, échéances, sanctions.",
        'lede'             => "Le décret BACS impose d'ÉQUIPER les bâtiments tertiaires d'une GTB (système d'automatisation) selon la puissance des systèmes CVC ; le décret tertiaire impose un RÉSULTAT de réduction de consommation d'énergie. L'un porte sur le moyen (la GTB), l'autre sur l'objectif (la sobriété énergétique). Un même bâtiment peut être soumis aux deux.",

        'a_label' => 'Décret BACS',
        'b_label' => 'Décret tertiaire',

        'rows' => [
            ['label' => 'Référence',               'a' => 'Décret n°2020-887 (20/07/2020), modifié par le décret n°2025-1343 (26/12/2025)', 'b' => 'Décret n°2019-771 (23/07/2019), loi ELAN'],
            ['label' => 'Objet',                   'a' => "Obligation d'équiper en GTB (système d'automatisation et de contrôle)",         'b' => "Obligation de réduire la consommation d'énergie finale"],
            ['label' => "Seuil d'assujettissement", 'a' => 'Puissance CVC > 290 kW, puis 70 à 290 kW',                                       'b' => 'Bâtiments tertiaires de plus de 1 000 m²'],
            ['label' => 'Échéances',               'a' => '> 290 kW : 1er janvier 2025 · 70 à 290 kW : 1er janvier 2030',                   'b' => '-40 % en 2030, -50 % en 2040, -60 % en 2050'],
            ['label' => 'Exigence',                'a' => 'Fonctions R. 175-3 — classe B en pratique (EN 15232 / NF EN ISO 52120-1)',          'b' => 'Déclaration annuelle sur la plateforme OPERAT (ADEME)'],
            ['label' => 'Sanction / dérogation',   'a' => "Dérogation possible si l'étude montre un retour sur investissement > 10 ans",    'b' => 'Amende jusqu\'à 7 500 € par bâtiment (personnes morales)'],
        ],

        'choose' => [
            'a' => [
                'title' => 'Vous êtes concerné par le décret BACS si…',
                'items' => [
                    'Votre bâtiment tertiaire a des systèmes CVC > 70 kW',
                    'Vous devez installer ou mettre à niveau une GTB (classe B couramment visée)',
                    'Échéance 2025 (>290 kW) ou 2030 (70-290 kW)',
                ],
            ],
            'b' => [
                'title' => 'Vous êtes concerné par le décret tertiaire si…',
                'items' => [
                    'Votre bâtiment (ou partie) à usage tertiaire fait plus de 1 000 m²',
                    "Vous devez réduire la consommation d'énergie finale (-40 % en 2030)",
                    'Vous déclarez chaque année sur OPERAT',
                ],
            ],
        ],

        'faq' => [
            [
                'question' => 'Le décret BACS et le décret tertiaire, est-ce pareil ?',
                'answer'   => "Non. Le décret BACS impose d'équiper le bâtiment d'une GTB selon la puissance CVC ; le décret tertiaire impose un objectif de réduction de la consommation d'énergie selon la surface. Ils sont distincts mais souvent cumulatifs.",
            ],
            [
                'question' => 'À partir de quelle puissance la GTB est-elle obligatoire ?',
                'answer'   => 'Au titre du décret BACS : depuis le 1er janvier 2025 pour les systèmes CVC de plus de 290 kW, et à partir du 1er janvier 2030 pour la tranche 70 à 290 kW.',
            ],
            [
                'question' => 'Quelle classe de GTB viser pour le décret BACS ?',
                'answer'   => 'Le décret impose des fonctions (art. R. 175-3), pas une classe : la classe C suffit à la conformité. La classe B (EN 15232 / NF EN ISO 52120-1) est le niveau couramment visé et la condition de la prime CEE.',
            ],
            [
                'question' => 'Comment déclarer pour le décret tertiaire ?',
                'answer'   => 'Les consommations se déclarent chaque année sur la plateforme OPERAT, gérée par l\'ADEME.',
            ],
            [
                'question' => 'Peut-on être exempté du décret BACS ?',
                'answer'   => "Une dérogation est possible si une étude établit que le temps de retour sur investissement de la GTB dépasse 10 ans (art. R. 175-2 du CCH).",
            ],
        ],
    ],

];
