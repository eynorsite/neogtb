<?php

return [
    'title' => 'Mot de passe oublié',
    'heading' => 'Mot de passe oublié ?',
    'form' => [
        'email' => [
            'label' => 'Adresse e-mail',
        ],
        'actions' => [
            'request' => [
                'label' => 'Envoyer le lien',
            ],
        ],
    ],
    'notifications' => [
        'throttled' => [
            'title' => 'Trop de tentatives',
            'body' => 'Veuillez réessayer dans :seconds secondes.',
        ],
    ],
];
