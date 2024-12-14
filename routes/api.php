<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CheckoutController;

Route::prefix('v2')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/brands', [ProductController::class, 'brands']);


Route::get('/checkout/delivery-options', [CheckoutController::class, 'getDeliveryOptions']);
Route::post('/checkout/calculate-shipping-cost', [CheckoutController::class, 'calculateShippingCost']);
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);

    // Add other API routes here...
});
