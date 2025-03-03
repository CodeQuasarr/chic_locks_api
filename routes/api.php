<?php

use App\Http\Controllers\Api\v1\user\UserController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users', UserController::class);
});
