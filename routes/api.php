<?php

use App\Http\Controllers\Api\V1\User\UserAddressController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }
    App::setLocale($locale);
    return;
})->name('greeting');

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
});
require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users', UserController::class);
    Route::delete('users/{user}', [UserController::class, 'delete'])->name('users.delete');

    Route::prefix('users/{user}')->group(function () {
        Route::apiResource('addresses', UserAddressController::class);
    });
});
