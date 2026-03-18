<?php

return [

    'layout' => [
        'actions' => [
            'sidebar' => [
                'collapse' => 'Réduire la barre latérale',
                'expand' => 'Développer la barre latérale',
            ],
        ],
    ],

    'pages' => [
        'dashboard' => [
            'title' => 'Tableau de bord',
        ],
    ],

    'resources' => [
        'label' => 'Ressource',
        'plural_label' => 'Ressources',

        'pages' => [
            'create_record' => [
                'title' => 'Créer :label',
                'breadcrumb' => 'Créer',
            ],
            'edit_record' => [
                'title' => 'Modifier :label',
                'breadcrumb' => 'Modifier',
            ],
            'list_records' => [
                'title' => ':label',
                'breadcrumb' => 'Liste',
            ],
            'view_record' => [
                'title' => 'Voir :label',
                'breadcrumb' => 'Voir',
            ],
        ],
    ],

    'widgets' => [
        'account' => [
            'label' => 'Bienvenue',
        ],
    ],

];
