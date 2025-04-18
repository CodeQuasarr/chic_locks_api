<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Orders\OrderController;
use App\Http\Controllers\Api\V1\Orders\OrderItemController;
use App\Http\Controllers\Api\V1\Payments\PaymentStripeController;
use App\Http\Controllers\Api\V1\Products\ProductController;
use App\Http\Controllers\Api\V1\Users\UserAddressController;
use App\Http\Controllers\Api\V1\Users\UserController;
use Illuminate\Support\Facades\Route;



require __DIR__.'/auth.php';

Route::post('/create-payment-intent', [PaymentStripeController::class, 'createPaymentIntent']);

Route::prefix('products')->group(function () {
    Route::get('/check-stocks', [ProductController::class, 'checkStock'])->name('products.checkStock');
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('orders', OrderController::class);
    Route::get('me', [LoginController::class, 'me'])->name('user.login_info');
    Route::delete('users/{user}', [UserController::class, 'delete'])->name('users.delete');

    Route::prefix('users/{user}')->group(function () {
        Route::apiResource('addresses', UserAddressController::class);
    });

    Route::prefix('orders/{order}')->group(function () {
        Route::apiResource('items', OrderItemController::class);
    });
});
