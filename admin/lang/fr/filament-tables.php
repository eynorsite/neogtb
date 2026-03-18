<?php

return [

    'columns' => [
        'text' => [
            'actions' => [
                'collapse_list' => 'Afficher :count de moins',
                'expand_list' => 'Afficher :count de plus',
            ],
            'more_list_items' => 'et :count de plus',
        ],
        'toggle' => [
            'true' => 'Actif',
            'false' => 'Inactif',
        ],
    ],

    'fields' => [
        'search' => [
            'label' => 'Rechercher',
            'placeholder' => 'Rechercher',
        ],
        'bulk_select_page' => [
            'label' => 'Sélectionner/désélectionner tout pour les actions groupées.',
        ],
        'bulk_select_record' => [
            'label' => 'Sélectionner/désélectionner l\'élément :key pour les actions groupées.',
        ],
    ],

    'summary' => [
        'heading' => 'Résumé',
        'subheadings' => [
            'all' => 'Tous les :label',
            'group' => 'Résumé :group',
            'page' => 'Cette page',
        ],
        'summarizers' => [
            'average' => [
                'label' => 'Moyenne',
            ],
            'count' => [
                'label' => 'Total',
            ],
            'sum' => [
                'label' => 'Somme',
            ],
        ],
    ],

    'actions' => [
        'disable_reordering' => [
            'label' => 'Fin du réordonnancement',
        ],
        'enable_reordering' => [
            'label' => 'Réordonner',
        ],
        'filter' => [
            'label' => 'Filtrer',
        ],
        'group' => [
            'label' => 'Grouper',
        ],
        'open_bulk_actions' => [
            'label' => 'Actions groupées',
        ],
        'toggle_columns' => [
            'label' => 'Afficher/masquer les colonnes',
        ],
    ],

    'empty' => [
        'heading' => 'Aucun résultat',
        'description' => 'Aucun(e) :model trouvé(e).',
    ],

    'filters' => [
        'actions' => [
            'apply' => [
                'label' => 'Appliquer les filtres',
            ],
            'remove' => [
                'label' => 'Retirer le filtre',
            ],
            'remove_all' => [
                'label' => 'Retirer tous les filtres',
            ],
            'reset' => [
                'label' => 'Réinitialiser',
            ],
        ],
        'heading' => 'Filtres',
        'indicator' => 'Filtres actifs',
        'multi_select' => [
            'placeholder' => 'Tous',
        ],
        'select' => [
            'placeholder' => 'Tous',
        ],
        'trashed' => [
            'label' => 'Éléments supprimés',
            'only_trashed' => 'Uniquement les supprimés',
            'with_trashed' => 'Avec les supprimés',
            'without_trashed' => 'Sans les supprimés',
        ],
    ],

    'grouping' => [
        'fields' => [
            'group' => [
                'label' => 'Grouper par',
                'placeholder' => 'Grouper par',
            ],
            'direction' => [
                'label' => 'Ordre',
                'placeholder' => 'Ordre',
            ],
        ],
    ],

    'reorder_indicator' => 'Glissez-déposez pour réordonner.',

    'selection_indicator' => [
        'selected_count' => ':count sélectionné(s)',
        'actions' => [
            'select_all' => [
                'label' => 'Sélectionner les :count éléments',
            ],
            'deselect_all' => [
                'label' => 'Tout désélectionner',
            ],
        ],
    ],

    'sorting' => [
        'fields' => [
            'column' => [
                'label' => 'Trier par',
            ],
            'direction' => [
                'label' => 'Ordre de tri',
            ],
        ],
    ],

];
