<?php

use App\Http\Controllers\User\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\User\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\User\Frontend\AuthenticatedController as FrontendAuthenticatedController;
use App\Http\Controllers\User\Backend\AuthenticatedController as BackendAuthenticatedController;
use App\Http\Controllers\User\Backend\CommentController;
use App\Http\Controllers\User\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\User\Backend\ProfileController as BackendProfileController;
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
        Route::middleware('auth:web')->group(function(){
            Route::get('/profile',[FrontendProfileController::class, 'index'])->name('profile.index');
            Route::controller(FrontendOrderController::class)
                ->as('order.')
                ->prefix('/orders')
                ->group(function(){
                    Route::get('/','index')->name('index');
                    Route::get('/{order}','show')->name('show');
                });
        });

        // Guest User
        Route::middleware('guest:web')->group(function(){
            Route::as('auth.')
                ->controller(FrontendAuthenticatedController::class)
                ->group(function () {
                    Route::get('/login','login')->name('login');
                    Route::get('/register','register')->name('register');
                });
        });
        
    });
    
    // Backend Routes
    Route::as('api.user.')->group(function() {
        Route::post('/search',[ToppageController::class, 'search'])->name('search');

        // Authenticated User
        Route::middleware('auth:web')->group(function() {
            Route::controller(BackendOrderController::class)
                ->as('order.')
                ->group(function () {
                Route::post('/order/store', 'store')->name('store');
            });

            Route::controller(BackendAuthenticatedController::class)
                ->as('auth.')
                ->group(function () {
                    Route::post('logout','logout')->name('logout');
                });
            
            Route::controller(BackendProfileController::class)
                ->as('profile.')
                ->group(function() {
                    Route::put('/update/{user}', 'updateProfile')->name('update');
                    Route::put('/change-password/{user}', 'updatePassword')->name('change-password');
                });

            Route::post('/comment/store/{product}', [CommentController::class, 'store'])->name('comment.store');
            Route::delete('/comment/destroy/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
            Route::get('api/product/{product}', [ToppageController::class, 'apiGetProductData'])->name('product.show');
        });

        // Guest User
        Route::middleware('guest:web')->group(function() {
            Route::controller(BackendAuthenticatedController::class)
                ->as('auth.')
                ->group(function () {
                    Route::post('register','postRegister')->name('register');
                    Route::post('login', 'postLogin')->name('login');
                });
        });
    });
});