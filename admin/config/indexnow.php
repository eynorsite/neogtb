<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Clé de vérification IndexNow
    |--------------------------------------------------------------------------
    | Le fichier public/<key>.txt DOIT contenir exactement cette même clé
    | (c'est la preuve de propriété exigée par IndexNow). Si vous surchargez
    | INDEXNOW_KEY dans le .env, créez le fichier public correspondant.
    */
    'key' => env('INDEXNOW_KEY', '944fd085d5c667803346221f2f063d3a'),

    /*
    |--------------------------------------------------------------------------
    | Activation
    |--------------------------------------------------------------------------
    | null  → activé uniquement en production (défaut sûr : évite de pinger
    |         IndexNow avec des URLs localhost en dev).
    | true/false → force l'état, quel que soit l'environnement.
    */
    'enabled' => env('INDEXNOW_ENABLED', null),

    /*
    |--------------------------------------------------------------------------
    | Endpoint
    |--------------------------------------------------------------------------
    | api.indexnow.org relaie à tous les moteurs partenaires (Bing, Yandex,
    | Seznam, Naver…). Un seul envoi suffit.
    */
    'endpoint' => env('INDEXNOW_ENDPOINT', 'https://api.indexnow.org/indexnow'),

];
