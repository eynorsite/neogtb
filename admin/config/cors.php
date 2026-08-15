<?php

/*
|--------------------------------------------------------------------------
| Cross-Origin Resource Sharing (CORS)
|--------------------------------------------------------------------------
|
| Ce fichier n'existait pas : le framework appliquait donc ses valeurs par
| défaut, dont `allowed_origins => ['*']` sur tous les chemins `api/*`.
| Mesuré en production le 15 août 2026 :
|
|   curl -I -H "Origin: https://evil.example" https://neogtb.fr/api/chatbot/bootstrap
|   → access-control-allow-origin: *
|
| Aucune donnée sensible n'y transitait (la configuration du chatbot est déjà
| publique et les routes POST restent couvertes par CSRF), mais la règle par
| défaut s'appliquerait telle quelle à toute future route `api/*`.
|
| Les appels du site à ses propres routes sont same-origin : ils ne passent
| pas par CORS et ne sont donc pas concernés par cette restriction.
|
*/

return [

    'paths' => ['api/*'],

    'allowed_methods' => ['GET', 'POST'],

    // Domaine canonique uniquement. APP_URL vaut https://neogtb.fr en production.
    'allowed_origins' => array_values(array_unique(array_filter([
        env('APP_URL'),
        'https://neogtb.fr',
    ]))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Accept',
        'Content-Type',
        'X-CSRF-TOKEN',
        'X-Requested-With',
    ],

    'exposed_headers' => [],

    'max_age' => 3600,

    // Aucune route API ne s'appuie sur les cookies de session en cross-origin.
    'supports_credentials' => false,

];
