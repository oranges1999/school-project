<?php

use App\Http\Controllers\User\Backend\OrderController;
use App\Http\Controllers\User\Frontend\AuthenticatedController;
use App\Http\Controllers\User\Frontend\ToppageController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function() {
    // Frontend Routes
    Route::as('user.')->group(function () {

        Route::controller(ToppageController::class)->group(function () {
            Route::get('/', 'index')->name('toppage');
            Route::get('/category/{category}', 'show')->name('category.show');
            Route::get('/product/{product}', 'showProduct')->name('product.show');
            Route::get('cart', 'showCart')->name('cart.show');
        });

        // Authenticated User
        Route::middleware('auth:web')->group(function(){});

        // Guest User
        Route::middleware('guest')->group(function(){
            Route::as('auth.')
                ->controller(AuthenticatedController::class)
                ->group(function () {
                    Route::get('/login','login')->name('login');
                    Route::get('/register','register')->name('register');
                });
        });
        
    });
    
    // Backend Routes
    Route::as('api.user.')->group(function() {
        // Authenticated User
        Route::middleware('auth:web')->group(function() {
            Route::controller(OrderController::class)
                ->as('order.')
                ->group(function () {
                Route::post('/order/store', 'store')->name('store');
            });
        });

        // Guest User
        Route::middleware('guest')->group(function() {});
    });
});