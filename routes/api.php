<?php


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }
    App::setLocale($locale);
    return;
})->name('greeting');

// importer routes/api/auth.php
require __DIR__.'/api/api_v1.php';

