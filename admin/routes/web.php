<?php

use Illuminate\Support\Facades\Route;

// RGPD routes (rate limited)
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/rgpd/consent', [\App\Http\Controllers\RgpdConsentController::class, 'storeConsent']);
    Route::get('/rgpd/consent', [\App\Http\Controllers\RgpdConsentController::class, 'getConsent']);
    Route::delete('/rgpd/consent', [\App\Http\Controllers\RgpdConsentController::class, 'deleteConsent']);
    Route::post('/rgpd/request', [\App\Http\Controllers\RgpdConsentController::class, 'submitGdprRequest']);
});

// Frontend public routes
Route::get('/', [\App\Http\Controllers\PageController::class, 'show'])->defaults('slug', 'accueil');
Route::get('/blog', [\App\Http\Controllers\PageController::class, 'blog']);
Route::get('/blog/{slug}', [\App\Http\Controllers\PageController::class, 'article']);
Route::post('/contact/send', [\App\Http\Controllers\PageController::class, 'sendContact'])->middleware('throttle:5,1');

// Static pages (Blade views — must be BEFORE the catch-all)
Route::get('/about', fn() => view('front.about'));
Route::get('/faq', fn() => view('front.faq'));
Route::get('/contact', fn() => view('front.contact'));
Route::get('/reglementation', fn() => view('front.reglementation'));
Route::get('/positionnement', fn() => view('front.positionnement'));
Route::get('/gtb', fn() => view('front.gtb'));
Route::get('/gtc', fn() => view('front.gtc'));
Route::get('/solutions', fn() => view('front.solutions'));
Route::get('/mentions-legales', fn() => view('front.mentions-legales'));
Route::get('/politique-de-confidentialite', fn() => view('front.politique-de-confidentialite'));
Route::get('/mes-droits-rgpd', fn() => view('front.mes-droits-rgpd'));
Route::get('/newsletter-confirmee', fn() => view('front.newsletter-confirmee'));

// Interactive tools
Route::get('/audit', fn() => view('front.audit'));
Route::get('/comparateur', fn() => view('front.comparateur'));
Route::get('/generateur-cee', fn() => view('front.generateur-cee'));

// Dynamic pages catch-all (from database)
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '^(?!admin|livewire).*$');

// Brick editor standalone route (outside Filament panels wrapper)
Route::get('/admin/pages/{pageId}/bricks-editor', \App\Livewire\BrickEditor::class)
    ->middleware(['web', 'auth:admin'])
    ->name('brick-editor');
