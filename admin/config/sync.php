<?php

return [
    'astro_root' => env('ASTRO_ROOT', base_path('../')),
    'blog_content_path' => env('ASTRO_BLOG_CONTENT_PATH', '/var/www/neogtb-src/src/content/blog'),
    'pages_data_path' => env('ASTRO_PAGES_DATA_PATH', '/var/www/neogtb-src/src/data/pages'),
    'deploy_script' => env('ASTRO_DEPLOY_SCRIPT', '/var/www/neogtb-src/deploy.sh'),
    'rebuild_timeout' => env('ASTRO_REBUILD_TIMEOUT', 300),
];
