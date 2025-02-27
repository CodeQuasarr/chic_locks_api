<?php

use Illuminate\Support\Facades\Route;


Route::post('login', [\App\Http\Controllers\Api\v1\Authentication\LoginController::class, 'store'])->name('user.login');
Route::post('register', [\App\Http\Controllers\Api\v1\Authentication\RegisterController::class, 'store'])->name('user.register');
