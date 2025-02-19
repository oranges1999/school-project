<?php

use App\Http\Controllers\User\BackEnd\OrderController;
use App\Http\Controllers\User\Frontend\ToppageController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::as('user.')->group(function () {
    Route::controller(ToppageController::class)->group(function () {
        Route::get('/', 'index')->name('toppage');
        Route::get('/category/{category}', 'show')->name('category.show');
        Route::get('/product/{product}', 'showProduct')->name('product.show');
        Route::get('cart', 'showCart')->name('cart.show');
    });
});

// Backend Routes
Route::as('api.user.')->group(function() {
    Route::controller(OrderController::class)
        ->as('order.')
        ->group(function () {
        Route::post('/order/store', 'store')->name('store');
    });
});