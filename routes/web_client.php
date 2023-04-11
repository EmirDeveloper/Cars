<?php
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\VerificationController;
use App\Http\Controllers\Client\LoginController;
use App\Http\Controllers\Client\MessageController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;


Route::controller(HomeController::class)
    ->group(function () {
        Route::get('', 'index')->name('home');
        Route::get('/locale/{locale}', 'language')->name('language')->where('locale', '[a-z]+');
    });

Route::controller(CategoryController::class)
    ->group(function () {
        Route::get('category/show/{slug}', 'show')->name('category.show')->where('slug', '[A-Za-z0-9-]+');
        Route::get('category/create', 'create')->name('category.create')->where('id', '[0-9]+');
    });

Route::controller(MessageController::class)->group(function () {
    Route::get('/message', 'index')->name('message')->middleware(ProtectAgainstSpam::class);
    Route::post('/message/store', 'store')->name('message.store')->middleware(ProtectAgainstSpam::class);
    });

Route::controller(ProductController::class)
    ->group(function () {
        Route::get('product/index', 'index')->name('product.index');
        Route::get('product/create', 'create')->name('product.create')->where('id', '[0-9]+');
        Route::post('product/store', 'store')->name('product.store')->where('id', '[0-9]+');
        Route::delete('product/destroy/{id}', 'destroy')->name('product.destroy')->where('id', '[0-9]+');
        Route::get('product/edit/{id}', 'edit')->name('product.edit')->where('id', '[0-9]+');
        Route::put('product/update/{id}', 'update')->name('product.update')->where('id', '[0-9]+');
        Route::get('product/show/{slug}', 'show')->name('product.show')->where('slug', '[A-Za-z0-9-]+');
        Route::get('/product/{slug}', 'product')->name('product')->where('slug', '[A-Za-z0-9-]+');
        Route::get('/category/{slug}', 'category')->name('category')->where('slug', '[A-Za-z0-9-]+');
        Route::get('/location/{id}', 'location')->name('location')->where('id', '[0-9-]+');
        Route::get('/brand/{slug}', 'brand')->name('brand')->where('slug', '[A-Za-z0-9-]+');
    });

Route::controller(VerificationController::class)
    ->middleware(['guest:customer_web', 'throttle:10,1'])
    ->group(function () {
        Route::get('verification', 'create')->name('verification');
        Route::post('verification', 'store');
    });

Route::controller(LoginController::class)
    ->middleware('guest:customer_web')
    ->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store');
    });

Route::controller(LoginController::class)
    ->middleware('auth:customer_web')
    ->group(function () {
        Route::post('/logout', 'destroy')->name('logout');
    });