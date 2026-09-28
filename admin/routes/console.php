<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('rgpd:purge-expired')->dailyAt('03:00');

// GEO/SEO : signale à IndexNow (Bing/Copilot, Yandex…) le contenu modifié dans les dernières 48 h.
// No-op automatique hors production (voir config/indexnow.php).
Schedule::command('indexnow:submit')->dailyAt('04:00');

// Machine à articles : envoie les articles « Validé » (plateforme « Blog NeoGTB »)
// de la base Notion partagée avec eynor.fr, et publie à leur date les articles
// programmés. Toutes les heures entre 7 h et 21 h. Sans NOTION_TOKEN : ne fait rien.
Schedule::command('notion:sync-articles')
    ->hourlyAt(5)
    ->between('07:00', '21:00')
    ->withoutOverlapping()
    ->runInBackground();
