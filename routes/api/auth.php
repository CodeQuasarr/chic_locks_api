<?php


use Illuminate\Support\Facades\Route;


Route::post('login', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'store'])->name('user.login');
Route::post('register', [\App\Http\Controllers\Api\V1\Auth\RegisterController::class, 'store'])->name('user.register');
Route::get('refresh-token', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'refresh'])->name('user.refresh');
