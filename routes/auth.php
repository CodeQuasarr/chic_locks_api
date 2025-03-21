<?php


use Illuminate\Support\Facades\Route;


Route::post('login', [\App\Http\Controllers\Api\V1\Authentication\LoginController::class, 'store'])->name('user.login');
Route::post('register', [\App\Http\Controllers\Api\V1\Authentication\RegisterController::class, 'store'])->name('user.register');
Route::get('refresh-token', [\App\Http\Controllers\Api\V1\Authentication\LoginController::class, 'refresh'])->name('user.refresh');

Route::middleware('auth:sanctum')->group( function () {

});
