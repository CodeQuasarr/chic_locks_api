<?php

use App\Http\Controllers\Api\v1\user\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';
Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users', UserController::class);
});
