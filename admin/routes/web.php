<?php

use App\Http\Controllers\BrickPreviewController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ComparatifController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RgpdConsentController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StaticPageController;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// RGPD routes (rate limited)
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/rgpd/consent', [RgpdConsentController::class, 'storeConsent']);
    Route::get('/rgpd/consent', [RgpdConsentController::class, 'getConsent']);
    Route::delete('/rgpd/consent', [RgpdConsentController::class, 'deleteConsent']);
    Route::post('/rgpd/request', [RgpdConsentController::class, 'submitGdprRequest']);
});

// Sitemap XML (dynamic)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('front.sitemap');

// llms.txt — plan du site lisible par les LLM (proposition de standard llmstxt.org).
// Pas encore consommé officiellement par les moteurs IA (effet non garanti à ce jour),
// mais peu coûteux, propre, et utile aux agents/outils qui le lisent. Listé : pages
// piliers + articles publiés. Caché 1h. À placer AVANT le catch-all /{slug}.
Route::get('/llms.txt', function () {
    $content = Cache::remember('llms_txt', 3600, function () {
        $base = rtrim(url('/'), '/');

        $lines = [];
        $lines[] = '# NeoGTB - Tiers de confiance indépendant en Gestion Technique du Bâtiment (GTB/GTC)';
        $lines[] = '';
        $lines[] = '> NeoGTB est un tiers de confiance indépendant sur la Gestion Technique du Bâtiment '
            .'(GTB) et la Gestion Technique Centralisée (GTC), sans lien commercial avec les fabricants. '
            .'Ressources éducatives (protocoles BACnet, KNX, Modbus, LON ; normes ISO 52120-1 / EN 15232), '
            .'pré-diagnostic GTB gratuit, comparateur de solutions et accompagnement au décret BACS '
            .'(obligation GTB pour les bâtiments tertiaires) et au décret tertiaire.';
        $lines[] = '';
        $lines[] = '## Pages principales';
        $lines[] = '- [Qu\'est-ce que la GTB ?]('.$base.'/gtb)';
        $lines[] = '- [Qu\'est-ce que la GTC ?]('.$base.'/gtc)';
        $lines[] = '- [Solutions & technologies (protocoles, capteurs, automates)]('.$base.'/solutions)';
        $lines[] = '- [Réglementation (décret BACS, décret tertiaire, RE2020)]('.$base.'/reglementation)';
        $lines[] = '- [Comparateur indépendant de solutions GTB]('.$base.'/comparateur)';
        $lines[] = '- [Pré-diagnostic GTB gratuit (ISO 52120-1)]('.$base.'/audit)';
        $lines[] = '- [Générateur CEE (BAT-TH-116)]('.$base.'/generateur-cee)';
        $lines[] = '- [Tables Modbus]('.$base.'/tables-modbus)';
        $lines[] = '- [Questions fréquentes (FAQ)]('.$base.'/faq)';
        $lines[] = '- [À propos de NeoGTB]('.$base.'/about)';
        $lines[] = '- [Contact]('.$base.'/contact)';
        $lines[] = '';
        $lines[] = '## Comparatifs';
        $lines[] = '- [GTB vs GTC : quelle différence ?]('.$base.'/comparatif/gtb-vs-gtc)';
        $lines[] = '- [Décret BACS vs décret tertiaire : quelle différence ?]('.$base.'/comparatif/decret-bacs-vs-decret-tertiaire)';
        $lines[] = '';
        $lines[] = '## Guides';
        $lines[] = '- [BACnet, KNX, Modbus, LON : quel protocole pour la GTB ?]('.$base.'/guide/protocoles-gtb)';
        $lines[] = '- [Les classes EN 15232 (ISO 52120-1) : A, B, C, D]('.$base.'/guide/classes-en-15232)';
        $lines[] = '- [À partir de quelle puissance la GTB est-elle obligatoire ?]('.$base.'/guide/gtb-obligatoire-puissance)';
        $lines[] = '';
        $lines[] = '## Blog - articles techniques GTB/GTC';

        Post::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', Carbon::now());
            })
            ->orderByDesc('published_at')
            ->get(['title', 'slug', 'excerpt'])
            ->each(function ($post) use (&$lines, $base) {
                if (blank($post->slug)) {
                    return;
                }
                $desc = trim((string) $post->excerpt);
                $suffix = $desc !== '' ? ' : '.Str::limit(strip_tags($desc), 120) : '';
                $lines[] = '- ['.$post->title.']('.$base.'/blog/'.$post->slug.')'.$suffix;
            });

        $lines[] = '';

        return implode("\n", $lines)."\n";
    });

    return response($content, 200)->header('Content-Type', 'text/plain; charset=utf-8');
})->name('front.llms');

// Frontend public routes
Route::get('/', [StaticPageController::class, 'accueil'])->name('front.home');
Route::get('/blog', [PageController::class, 'blog'])->name('front.blog');
Route::get('/blog/{slug}', [PageController::class, 'article'])->name('front.article');
Route::post('/contact/send', [PageController::class, 'sendContact'])->middleware('throttle:5,1')->name('front.contact.send');
Route::post('/audit/lead', [PageController::class, 'storeAuditLead'])->middleware('throttle:5,1')->name('front.audit.lead');
Route::post('/cee/lead', [PageController::class, 'storeCeeLead'])->middleware('throttle:5,1')->name('front.cee.lead');

// Static pages (Blade views — must be BEFORE the catch-all)
Route::get('/about', [StaticPageController::class, 'about'])->name('front.about');
Route::get('/faq', [StaticPageController::class, 'faq'])->name('front.faq');
Route::get('/contact', [StaticPageController::class, 'contact'])->name('front.contact');
Route::get('/reglementation', [StaticPageController::class, 'reglementation'])->name('front.reglementation');
Route::get('/positionnement', [StaticPageController::class, 'positionnement'])->name('front.positionnement');
Route::get('/gtb', [StaticPageController::class, 'gtb'])->name('front.gtb');
Route::get('/gtc', [StaticPageController::class, 'gtc'])->name('front.gtc');
Route::get('/solutions', [StaticPageController::class, 'solutions'])->name('front.solutions');
Route::get('/mentions-legales', [StaticPageController::class, 'mentionsLegales'])->name('front.mentions-legales');
Route::get('/politique-de-confidentialite', [StaticPageController::class, 'politiqueConfidentialite'])->name('front.politique-confidentialite');
Route::get('/mes-droits-rgpd', [StaticPageController::class, 'mesDroitsRgpd'])->name('front.mes-droits-rgpd');
Route::get('/cookies', [StaticPageController::class, 'cookies'])->name('front.cookies');
Route::get('/newsletter-confirmee', [StaticPageController::class, 'newsletterConfirmee'])->name('front.newsletter-confirmee');

// Interactive tools
Route::get('/audit', [StaticPageController::class, 'audit'])->name('front.audit');
Route::get('/comparateur', [StaticPageController::class, 'comparateur'])->name('front.comparateur');
Route::get('/generateur-cee', [StaticPageController::class, 'generateurCee'])->name('front.generateur-cee');
Route::get('/tables-modbus', [StaticPageController::class, 'tablesModbus'])->name('front.tables-modbus');

// Pages comparatives GEO (config-driven — cf. config/comparatifs-gtb.php)
Route::get('/comparatif/{slug}', [ComparatifController::class, 'show'])->where('slug', 'gtb-vs-gtc|decret-bacs-vs-decret-tertiaire')->name('front.comparatif');

// Pages-guides GEO (config-driven — cf. config/guides-gtb.php)
Route::get('/guide/{slug}', [GuideController::class, 'show'])->where('slug', 'protocoles-gtb|classes-en-15232|gtb-obligatoire-puissance')->name('front.guide');

// Newsletter (double opt-in)
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});
Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');

// Chatbot API routes
Route::prefix('api/chatbot')->group(function () {
    Route::get('/bootstrap', [ChatbotController::class, 'bootstrap'])
        ->middleware('throttle:60,1')
        ->name('chatbot.bootstrap');
    Route::post('/consent', [ChatbotController::class, 'consent'])
        ->middleware('throttle:30,1')
        ->name('chatbot.consent');
    Route::post('/stream', [ChatbotController::class, 'stream'])
        ->middleware('throttle:30,1')
        ->name('chatbot.stream');
    Route::post('/lead', [ChatbotController::class, 'captureLead'])
        ->middleware('throttle:5,1')
        ->name('chatbot.lead');
});

// Brick editor preview routes
Route::middleware(['web'])->prefix('admin/api/bricks')->group(function () {
    Route::get('/preview/{pageId}', [BrickPreviewController::class, 'previewPage'])
        ->where('pageId', '[0-9]+')
        ->name('admin.bricks.preview.page');

    Route::get('/{brickId}/render', [BrickPreviewController::class, 'renderBrick'])
        ->where('brickId', '[0-9]+')
        ->name('admin.bricks.preview.render');
});

// Dynamic pages catch-all (from database)
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '^(?!admin|livewire).*$');

// Ancien brick editor supprimé — remplacé par PageContentsPage Filament (/admin/page-contents-page)
