<?php

return [

    'components' => [

        'builder' => [
            'actions' => [
                'clone' => [
                    'label' => 'Dupliquer',
                ],
                'add' => [
                    'label' => 'Ajouter à :label',
                    'modal' => [
                        'heading' => 'Ajouter à :label',
                        'actions' => [
                            'add' => [
                                'label' => 'Ajouter',
                            ],
                        ],
                    ],
                ],
                'add_between' => [
                    'label' => 'Insérer',
                    'modal' => [
                        'heading' => 'Ajouter à :label',
                        'actions' => [
                            'add' => [
                                'label' => 'Ajouter',
                            ],
                        ],
                    ],
                ],
                'delete' => [
                    'label' => 'Supprimer',
                ],
                'edit' => [
                    'label' => 'Modifier',
                    'modal' => [
                        'heading' => 'Modifier le bloc',
                        'actions' => [
                            'save' => [
                                'label' => 'Enregistrer',
                            ],
                        ],
                    ],
                ],
                'reorder' => [
                    'label' => 'Déplacer',
                ],
                'move_down' => [
                    'label' => 'Descendre',
                ],
                'move_up' => [
                    'label' => 'Monter',
                ],
                'collapse' => [
                    'label' => 'Réduire',
                ],
                'expand' => [
                    'label' => 'Développer',
                ],
                'collapse_all' => [
                    'label' => 'Tout réduire',
                ],
                'expand_all' => [
                    'label' => 'Tout développer',
                ],
            ],
        ],

        'checkbox_list' => [
            'actions' => [
                'deselect_all' => [
                    'label' => 'Tout désélectionner',
                ],
                'select_all' => [
                    'label' => 'Tout sélectionner',
                ],
            ],
        ],

        'file_upload' => [
            'editor' => [
                'actions' => [
                    'cancel' => [
                        'label' => 'Annuler',
                    ],
                    'drag_crop' => [
                        'label' => 'Recadrer',
                    ],
                    'drag_move' => [
                        'label' => 'Déplacer',
                    ],
                    'flip_horizontal' => [
                        'label' => 'Retourner horizontalement',
                    ],
                    'flip_vertical' => [
                        'label' => 'Retourner verticalement',
                    ],
                    'move_down' => [
                        'label' => 'Descendre',
                    ],
                    'move_left' => [
                        'label' => 'Déplacer à gauche',
                    ],
                    'move_right' => [
                        'label' => 'Déplacer à droite',
                    ],
                    'move_up' => [
                        'label' => 'Monter',
                    ],
                    'rotate_left' => [
                        'label' => 'Rotation gauche',
                    ],
                    'rotate_right' => [
                        'label' => 'Rotation droite',
                    ],
                    'save' => [
                        'label' => 'Enregistrer',
                    ],
                    'zoom_100' => [
                        'label' => 'Zoom 100%',
                    ],
                    'zoom_in' => [
                        'label' => 'Zoom avant',
                    ],
                    'zoom_out' => [
                        'label' => 'Zoom arrière',
                    ],
                ],
            ],
        ],

        'key_value' => [
            'actions' => [
                'add' => [
                    'label' => 'Ajouter une ligne',
                ],
                'delete' => [
                    'label' => 'Supprimer la ligne',
                ],
                'reorder' => [
                    'label' => 'Réordonner la ligne',
                ],
            ],
            'fields' => [
                'key' => [
                    'label' => 'Clé',
                ],
                'value' => [
                    'label' => 'Valeur',
                ],
            ],
        ],

        'markdown_editor' => [
            'toolbar_buttons' => [
                'attach_files' => 'Joindre des fichiers',
                'blockquote' => 'Citation',
                'bold' => 'Gras',
                'bullet_list' => 'Liste à puces',
                'code_block' => 'Bloc de code',
                'heading' => 'Titre',
                'italic' => 'Italique',
                'link' => 'Lien',
                'ordered_list' => 'Liste numérotée',
                'redo' => 'Rétablir',
                'strike' => 'Barré',
                'table' => 'Tableau',
                'undo' => 'Annuler',
            ],
        ],

        'repeater' => [
            'actions' => [
                'add' => [
                    'label' => 'Ajouter à :label',
                ],
                'add_between' => [
                    'label' => 'Insérer',
                ],
                'clone' => [
                    'label' => 'Dupliquer',
                ],
                'collapse' => [
                    'label' => 'Réduire',
                ],
                'collapse_all' => [
                    'label' => 'Tout réduire',
                ],
                'delete' => [
                    'label' => 'Supprimer',
                ],
                'expand' => [
                    'label' => 'Développer',
                ],
                'expand_all' => [
                    'label' => 'Tout développer',
                ],
                'move_down' => [
                    'label' => 'Descendre',
                ],
                'move_up' => [
                    'label' => 'Monter',
                ],
                'reorder' => [
                    'label' => 'Déplacer',
                ],
            ],
        ],

        'rich_editor' => [
            'toolbar_buttons' => [
                'attach_files' => 'Joindre des fichiers',
                'blockquote' => 'Citation',
                'bold' => 'Gras',
                'bullet_list' => 'Liste à puces',
                'code_block' => 'Bloc de code',
                'h2' => 'Titre 2',
                'h3' => 'Titre 3',
                'italic' => 'Italique',
                'link' => 'Lien',
                'ordered_list' => 'Liste numérotée',
                'redo' => 'Rétablir',
                'strike' => 'Barré',
                'underline' => 'Souligné',
                'undo' => 'Annuler',
            ],
        ],

        'select' => [
            'actions' => [
                'create_option' => [
                    'label' => 'Créer',
                    'modal' => [
                        'heading' => 'Créer',
                        'actions' => [
                            'create' => [
                                'label' => 'Créer',
                            ],
                            'create_another' => [
                                'label' => 'Créer et en ajouter un autre',
                            ],
                        ],
                    ],
                ],
                'edit_option' => [
                    'label' => 'Modifier',
                    'modal' => [
                        'heading' => 'Modifier',
                        'actions' => [
                            'save' => [
                                'label' => 'Enregistrer',
                            ],
                        ],
                    ],
                ],
            ],
            'boolean' => [
                'true' => 'Oui',
                'false' => 'Non',
            ],
            'loading_message' => 'Chargement...',
            'max_items_message' => ':count éléments maximum.',
            'no_search_results_message' => 'Aucun résultat.',
            'placeholder' => 'Sélectionnez une option',
            'searching_message' => 'Recherche...',
            'search_prompt' => 'Commencez à taper pour rechercher...',
        ],

        'tags_input' => [
            'placeholder' => 'Nouveau tag',
        ],

        'wizard' => [
            'actions' => [
                'previous_step' => [
                    'label' => 'Précédent',
                ],
                'next_step' => [
                    'label' => 'Suivant',
                ],
            ],
        ],

    ],

];
