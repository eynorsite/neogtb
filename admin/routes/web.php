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
Route::get('/', [\App\Http\Controllers\StaticPageController::class, 'accueil'])->name('front.home');
Route::get('/blog', [\App\Http\Controllers\PageController::class, 'blog'])->name('front.blog');
Route::get('/blog/{slug}', [\App\Http\Controllers\PageController::class, 'article'])->name('front.article');
Route::post('/contact/send', [\App\Http\Controllers\PageController::class, 'sendContact'])->middleware('throttle:5,1')->name('front.contact.send');

// Static pages (Blade views — must be BEFORE the catch-all)
Route::get('/about', [\App\Http\Controllers\StaticPageController::class, 'about'])->name('front.about');
Route::get('/faq', [\App\Http\Controllers\StaticPageController::class, 'faq'])->name('front.faq');
Route::get('/contact', [\App\Http\Controllers\StaticPageController::class, 'contact'])->name('front.contact');
Route::get('/reglementation', [\App\Http\Controllers\StaticPageController::class, 'reglementation'])->name('front.reglementation');
Route::get('/positionnement', [\App\Http\Controllers\StaticPageController::class, 'positionnement'])->name('front.positionnement');
Route::get('/gtb', [\App\Http\Controllers\StaticPageController::class, 'gtb'])->name('front.gtb');
Route::get('/gtc', [\App\Http\Controllers\StaticPageController::class, 'gtc'])->name('front.gtc');
Route::get('/solutions', [\App\Http\Controllers\StaticPageController::class, 'solutions'])->name('front.solutions');
Route::get('/mentions-legales', [\App\Http\Controllers\StaticPageController::class, 'mentionsLegales'])->name('front.mentions-legales');
Route::get('/politique-de-confidentialite', [\App\Http\Controllers\StaticPageController::class, 'politiqueConfidentialite'])->name('front.politique-confidentialite');
Route::get('/mes-droits-rgpd', [\App\Http\Controllers\StaticPageController::class, 'mesDroitsRgpd'])->name('front.mes-droits-rgpd');
Route::get('/newsletter-confirmee', [\App\Http\Controllers\StaticPageController::class, 'newsletterConfirmee'])->name('front.newsletter-confirmee');

// Interactive tools
Route::get('/audit', [\App\Http\Controllers\StaticPageController::class, 'audit'])->name('front.audit');
Route::get('/comparateur', [\App\Http\Controllers\StaticPageController::class, 'comparateur'])->name('front.comparateur');
Route::get('/generateur-cee', [\App\Http\Controllers\StaticPageController::class, 'generateurCee'])->name('front.generateur-cee');

// Dynamic pages catch-all (from database)
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '^(?!admin|livewire).*$');

// Brick editor standalone route (outside Filament panels wrapper)
Route::get('/admin/pages/{pageId}/bricks-editor', \App\Livewire\BrickEditor::class)
    ->middleware(['web', 'auth:admin'])
    ->name('brick-editor');
