<?php

use Illuminate\Support\Facades\Route;

// Frontend public routes
Route::get('/', [\App\Http\Controllers\PageController::class, 'show'])->defaults('slug', 'accueil');
Route::get('/blog', [\App\Http\Controllers\PageController::class, 'blog']);
Route::get('/blog/{slug}', [\App\Http\Controllers\PageController::class, 'article']);
Route::post('/contact/send', [\App\Http\Controllers\PageController::class, 'sendContact']);
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->where('slug', '^(?!admin|livewire).*$');

// Brick editor standalone route (outside Filament panels wrapper)
Route::get('/admin/pages/{pageId}/bricks-editor', \App\Livewire\BrickEditor::class)
    ->middleware(['web', 'auth:admin'])
    ->name('brick-editor');
