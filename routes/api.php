<?php


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
    Route::get('me', [\App\Http\Controllers\Api\v1\Authentication\LoginController::class, 'me'])->name('user.login_info');
    Route::apiResource('users', \App\Http\Controllers\Api\v1\User\UserController::class);
    Route::delete('users/{user}', [\App\Http\Controllers\Api\v1\User\UserController::class, 'delete'])->name('users.delete');

    Route::prefix('users/{user}')->group(function () {
        Route::apiResource('addresses', \App\Http\Controllers\Api\v1\User\UserAddressController::class);
    });
});
