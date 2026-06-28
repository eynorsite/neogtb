<?php

use Illuminate\Support\Facades\Route;

// RGPD routes (rate limited)
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/rgpd/consent', [\App\Http\Controllers\RgpdConsentController::class, 'storeConsent']);
    Route::get('/rgpd/consent', [\App\Http\Controllers\RgpdConsentController::class, 'getConsent']);
    Route::delete('/rgpd/consent', [\App\Http\Controllers\RgpdConsentController::class, 'deleteConsent']);
    Route::post('/rgpd/request', [\App\Http\Controllers\RgpdConsentController::class, 'submitGdprRequest']);
});

// Sitemap XML (dynamic)
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('front.sitemap');

// llms.txt — plan du site lisible par les LLM (proposition de standard llmstxt.org).
// Pas encore consommé officiellement par les moteurs IA (effet non garanti à ce jour),
// mais peu coûteux, propre, et utile aux agents/outils qui le lisent. Listé : pages
// piliers + articles publiés. Caché 1h. À placer AVANT le catch-all /{slug}.
Route::get('/llms.txt', function () {
    $content = \Illuminate\Support\Facades\Cache::remember('llms_txt', 3600, function () {
        $base = rtrim(url('/'), '/');

        $lines = [];
        $lines[] = '# NeoGTB - Tiers de confiance indépendant en Gestion Technique du Bâtiment (GTB/GTC)';
        $lines[] = '';
        $lines[] = '> NeoGTB est un tiers de confiance indépendant sur la Gestion Technique du Bâtiment '
            . '(GTB) et la Gestion Technique Centralisée (GTC), sans lien commercial avec les fabricants. '
            . 'Ressources éducatives (protocoles BACnet, KNX, Modbus, LON ; normes ISO 52120-1 / EN 15232), '
            . 'pré-diagnostic GTB gratuit, comparateur de solutions et accompagnement au décret BACS '
            . '(obligation GTB pour les bâtiments tertiaires) et au décret tertiaire.';
        $lines[] = '';
        $lines[] = '## Pages principales';
        $lines[] = '- [Qu\'est-ce que la GTB ?](' . $base . '/gtb)';
        $lines[] = '- [Qu\'est-ce que la GTC ?](' . $base . '/gtc)';
        $lines[] = '- [Solutions & technologies (protocoles, capteurs, automates)](' . $base . '/solutions)';
        $lines[] = '- [Réglementation (décret BACS, décret tertiaire, RE2020)](' . $base . '/reglementation)';
        $lines[] = '- [Comparateur indépendant de solutions GTB](' . $base . '/comparateur)';
        $lines[] = '- [Pré-diagnostic GTB gratuit (ISO 52120-1)](' . $base . '/audit)';
        $lines[] = '- [Générateur CEE (BAT-TH-116)](' . $base . '/generateur-cee)';
        $lines[] = '- [Tables Modbus](' . $base . '/tables-modbus)';
        $lines[] = '- [Questions fréquentes (FAQ)](' . $base . '/faq)';
        $lines[] = '- [À propos de NeoGTB](' . $base . '/about)';
        $lines[] = '- [Contact](' . $base . '/contact)';
        $lines[] = '';
        $lines[] = '## Comparatifs';
        $lines[] = '- [GTB vs GTC : quelle différence ?](' . $base . '/comparatif/gtb-vs-gtc)';
        $lines[] = '- [Décret BACS vs décret tertiaire : quelle différence ?](' . $base . '/comparatif/decret-bacs-vs-decret-tertiaire)';
        $lines[] = '';
        $lines[] = '## Guides';
        $lines[] = '- [BACnet, KNX, Modbus, LON : quel protocole pour la GTB ?](' . $base . '/guide/protocoles-gtb)';
        $lines[] = '- [Les classes EN 15232 (ISO 52120-1) : A, B, C, D](' . $base . '/guide/classes-en-15232)';
        $lines[] = '- [À partir de quelle puissance la GTB est-elle obligatoire ?](' . $base . '/guide/gtb-obligatoire-puissance)';
        $lines[] = '';
        $lines[] = '## Blog - articles techniques GTB/GTC';

        \App\Models\Post::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', \Illuminate\Support\Carbon::now());
            })
            ->orderByDesc('published_at')
            ->get(['title', 'slug', 'excerpt'])
            ->each(function ($post) use (&$lines, $base) {
                if (blank($post->slug)) {
                    return;
                }
                $desc = trim((string) $post->excerpt);
                $suffix = $desc !== '' ? ' : ' . \Illuminate\Support\Str::limit(strip_tags($desc), 120) : '';
                $lines[] = '- [' . $post->title . '](' . $base . '/blog/' . $post->slug . ')' . $suffix;
            });

        $lines[] = '';

        return implode("\n", $lines) . "\n";
    });

    return response($content, 200)->header('Content-Type', 'text/plain; charset=utf-8');
})->name('front.llms');

// Frontend public routes
Route::get('/', [\App\Http\Controllers\StaticPageController::class, 'accueil'])->name('front.home');
Route::get('/blog', [\App\Http\Controllers\PageController::class, 'blog'])->name('front.blog');
Route::get('/blog/{slug}', [\App\Http\Controllers\PageController::class, 'article'])->name('front.article');
Route::post('/contact/send', [\App\Http\Controllers\PageController::class, 'sendContact'])->middleware('throttle:5,1')->name('front.contact.send');
Route::post('/audit/lead', [\App\Http\Controllers\PageController::class, 'storeAuditLead'])->middleware('throttle:5,1')->name('front.audit.lead');
Route::post('/cee/lead', [\App\Http\Controllers\PageController::class, 'storeCeeLead'])->middleware('throttle:5,1')->name('front.cee.lead');
Route::post('/modele-cctp-decret-bacs/telecharger', [\App\Http\Controllers\PageController::class, 'downloadCctpModele'])->middleware('throttle:5,1')->name('front.cctp.download');

// Static pages (Blade views — must be BEFORE the catch-all)
Route::get('/about', [\App\Http\Controllers\StaticPageController::class, 'about'])->name('front.about');
Route::get('/faq', [\App\Http\Controllers\StaticPageController::class, 'faq'])->name('front.faq');
Route::get('/contact', [\App\Http\Controllers\StaticPageController::class, 'contact'])->name('front.contact');
Route::get('/reglementation', [\App\Http\Controllers\StaticPageController::class, 'reglementation'])->name('front.reglementation');
Route::get('/decret-bacs', [\App\Http\Controllers\StaticPageController::class, 'decretBacs'])->name('front.decret-bacs');
Route::get('/modele-cctp-decret-bacs', [\App\Http\Controllers\StaticPageController::class, 'modeleCctpDecretBacs'])->name('front.modele-cctp-decret-bacs');
Route::get('/amo-gtb-gtc', [\App\Http\Controllers\StaticPageController::class, 'amoGtbGtc'])->name('front.amo-gtb-gtc');
Route::get('/offres', [\App\Http\Controllers\StaticPageController::class, 'offres'])->name('front.offres');
Route::get('/offre-conformite-continue', [\App\Http\Controllers\StaticPageController::class, 'offreConformiteContinue'])->name('front.offre-conformite-continue');
Route::get('/positionnement', [\App\Http\Controllers\StaticPageController::class, 'positionnement'])->name('front.positionnement');
Route::get('/gtb', [\App\Http\Controllers\StaticPageController::class, 'gtb'])->name('front.gtb');
Route::get('/gtc', [\App\Http\Controllers\StaticPageController::class, 'gtc'])->name('front.gtc');
Route::get('/solutions', [\App\Http\Controllers\StaticPageController::class, 'solutions'])->name('front.solutions');
Route::get('/mentions-legales', [\App\Http\Controllers\StaticPageController::class, 'mentionsLegales'])->name('front.mentions-legales');
Route::get('/politique-de-confidentialite', [\App\Http\Controllers\StaticPageController::class, 'politiqueConfidentialite'])->name('front.politique-confidentialite');
Route::get('/mes-droits-rgpd', [\App\Http\Controllers\StaticPageController::class, 'mesDroitsRgpd'])->name('front.mes-droits-rgpd');
Route::get('/cookies', [\App\Http\Controllers\StaticPageController::class, 'cookies'])->name('front.cookies');
Route::get('/newsletter-confirmee', [\App\Http\Controllers\StaticPageController::class, 'newsletterConfirmee'])->name('front.newsletter-confirmee');

// Interactive tools
Route::get('/audit', [\App\Http\Controllers\StaticPageController::class, 'audit'])->name('front.audit');
Route::get('/comparateur', [\App\Http\Controllers\StaticPageController::class, 'comparateur'])->name('front.comparateur');
Route::get('/generateur-cee', [\App\Http\Controllers\StaticPageController::class, 'generateurCee'])->name('front.generateur-cee');
Route::get('/tables-modbus', [\App\Http\Controllers\StaticPageController::class, 'tablesModbus'])->name('front.tables-modbus');

// Pages comparatives GEO (config-driven — cf. config/comparatifs-gtb.php)
Route::get('/comparatif/{slug}', [\App\Http\Controllers\ComparatifController::class, 'show'])->where('slug', 'gtb-vs-gtc|decret-bacs-vs-decret-tertiaire')->name('front.comparatif');

// Pages-guides GEO (config-driven — cf. config/guides-gtb.php)
Route::get('/guide/{slug}', [\App\Http\Controllers\GuideController::class, 'show'])->where('slug', 'protocoles-gtb|classes-en-15232|gtb-obligatoire-puissance')->name('front.guide');

// Newsletter (double opt-in)
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/newsletter', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::post('/newsletter/unsubscribe', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});
Route::get('/newsletter/confirm/{token}', [\App\Http\Controllers\NewsletterController::class, 'confirm'])->name('newsletter.confirm');

// Chatbot API routes
Route::prefix('api/chatbot')->group(function () {
    Route::get('/bootstrap', [\App\Http\Controllers\ChatbotController::class, 'bootstrap'])
        ->middleware('throttle:60,1')
        ->name('chatbot.bootstrap');
    Route::post('/consent', [\App\Http\Controllers\ChatbotController::class, 'consent'])
        ->middleware('throttle:30,1')
        ->name('chatbot.consent');
    Route::post('/stream', [\App\Http\Controllers\ChatbotController::class, 'stream'])
        ->middleware('throttle:30,1')
        ->name('chatbot.stream');
    Route::post('/lead', [\App\Http\Controllers\ChatbotController::class, 'captureLead'])
        ->middleware('throttle:5,1')
        ->name('chatbot.lead');
});

// Brick editor preview routes
Route::middleware(['web'])->prefix('admin/api/bricks')->group(function () {
    Route::get('/preview/{pageId}', [\App\Http\Controllers\BrickPreviewController::class, 'previewPage'])
        ->where('pageId', '[0-9]+')
        ->name('admin.bricks.preview.page');

    Route::get('/{brickId}/render', [\App\Http\Controllers\BrickPreviewController::class, 'renderBrick'])
        ->where('brickId', '[0-9]+')
        ->name('admin.bricks.preview.render');
});

// Dynamic pages catch-all (from database)
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '^(?!admin|livewire).*$');

// Ancien brick editor supprimé — remplacé par PageContentsPage Filament (/admin/page-contents-page)
