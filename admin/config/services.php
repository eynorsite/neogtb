<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'anthropic' => [
        'api_key' => env('ANTHROPIC_API_KEY'),
    ],

    /*
    | Machine à articles (Notion → blog neogtb.fr), cf. NotionSyncArticles.
    | Même base Notion que eynor.fr (« Calendrier de contenu ») : ce site ne
    | prend que les pages dont la « Plateforme » vaut « Blog NeoGTB ». Sans
    | jeton, la commande ne fait rien. Le jeton peut être celui de l'intégration
    | déjà utilisée par eynor.fr (elle a accès à la base).
    */
    'notion' => [
        'token' => env('NOTION_TOKEN'),
        'blog_data_source_id' => env('NOTION_BLOG_DATA_SOURCE_ID', '980815be-4850-826f-b698-87a29c09681a'),
        'platform' => env('NOTION_BLOG_PLATFORM', 'Blog NeoGTB'),
        // Auteur (email d'un compte admin) des articles. Si vide → premier admin.
        'sync_author_email' => env('NOTION_SYNC_AUTHOR_EMAIL'),
        // Catégorie si la page Notion n'en précise aucune (créée si absente).
        'default_category' => env('NOTION_DEFAULT_CATEGORY', 'Guide'),
    ],

];
