<?php

return [
    'title' => 'Connexion',
    'heading' => 'Connexion',
    'form' => [
        'email' => [
            'label' => 'Adresse e-mail',
        ],
        'password' => [
            'label' => 'Mot de passe',
        ],
        'remember' => [
            'label' => 'Se souvenir de moi',
        ],
        'actions' => [
            'authenticate' => [
                'label' => 'Se connecter',
            ],
        ],
    ],
    'messages' => [
        'failed' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
        'throttled' => 'Trop de tentatives. Veuillez réessayer dans :seconds secondes.',
    ],
    'notifications' => [
        'throttled' => [
            'title' => 'Trop de tentatives',
            'body' => 'Veuillez réessayer dans :seconds secondes.',
        ],
    ],
];
