<?php

use App\Http\Controllers\Api\v1\Authentication\LoginController;
use App\Http\Controllers\Api\v1\Authentication\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('login', [LoginController::class, 'store'])->name('user.login');
Route::post('register', [RegisterController::class, 'store'])->name('user.register');
Route::get('refresh-token', [LoginController::class, 'refresh'])->name('user.refresh');

Route::middleware('auth:sanctum')->group( function () {
    Route::get('me', [LoginController::class, 'me'])->name('user.login_info');
});
