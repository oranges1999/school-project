<?php

use App\Http\Controllers\Admin\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Admin\Backend\CategoryController as BackendCategoryController;
use App\Http\Controllers\Admin\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Admin\Backend\ProductController as BackendProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Frontend Routes
Route::prefix('admin/')->as('admin.')->group(function(){
    // Category Routes
    Route::prefix('categories/')
        ->as('categories.')
        ->controller(FrontendCategoryController::class)
        ->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
    });

    // Products Routes
    Route::prefix('products/')
        ->as('products.')
        ->controller(FrontendProductController::class)
        ->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
        });
});

// Backend Routes
Route::prefix('api/admin/')->as('api.admin.')->group(function(){
    // Category Routes
    Route::prefix('categories/')
        ->as('categories.')
        ->controller(BackendCategoryController::class)
        ->group(function(){
            Route::get('/get-data', 'getData')->name('get-data');
            Route::post('/store', 'store')->name('store');
            Route::delete('/destroy', 'destroy')->name('destroy');
    });

    // Products Routes
    Route::prefix('products/')
        ->as('products.')
        ->controller(BackendProductController::class)
        ->group(function(){
            Route::get('get-data','getData')->name('get-data');
            Route::post('/store', 'store')->name('store');
            Route::delete('/destroy','destroy')->name('destroy');
        });
});