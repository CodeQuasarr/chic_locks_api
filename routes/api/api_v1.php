<?php

use Illuminate\Support\Facades\Route;



require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group( function () {
    Route::get('me', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'me'])->name('user.login_info');
    Route::apiResource('users', \App\Http\Controllers\Api\V1\Users\UserController::class);
    Route::delete('users/{user}', [\App\Http\Controllers\Api\V1\Users\UserController::class, 'delete'])->name('users.delete');

    Route::prefix('users/{user}')->group(function () {
        Route::apiResource('addresses', \App\Http\Controllers\Api\V1\Users\UserAddressController::class);
    });
});
