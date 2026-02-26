<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shop — Product Routes
|--------------------------------------------------------------------------
*/

Route::get('/',                  [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search',   [ProductController::class, 'liveSearch'])->name('products.live-search');
Route::get('/products/{product}',[ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Shop — Cart & Checkout Routes
|--------------------------------------------------------------------------
*/

Route::get('/cart',                        [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}',         [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}',      [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update/{id}',          [CartController::class, 'update'])->name('cart.update');
Route::post('/checkout',                   [CartController::class, 'checkout'])->middleware('auth')->name('checkout');

Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('auth')->name('orders.show');

/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::redirect('/dashboard', '/')->name('dashboard');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->middleware('auth')->name('my.orders');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Merchant Routes (merchant + master_admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:merchant'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('products', App\Http\Controllers\Admin\ProductController::class)
            ->names('products');

    });

/*
|--------------------------------------------------------------------------
| Admin Routes (admin + master_admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('merchants',           [App\Http\Controllers\Admin\MerchantController::class, 'index'])->name('merchants.index');
        Route::get('merchants/create',    [App\Http\Controllers\Admin\MerchantController::class, 'create'])->name('merchants.create');
        Route::post('merchants',          [App\Http\Controllers\Admin\MerchantController::class, 'store'])->name('merchants.store');
        Route::delete('merchants/{user}', [App\Http\Controllers\Admin\MerchantController::class, 'destroy'])->name('merchants.destroy');

    });

/*
|--------------------------------------------------------------------------
| Master Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:master'])
    ->prefix('master')
    ->name('master.')
    ->group(function () {

        Route::get('admins',           [App\Http\Controllers\MasterAdmin\AdminController::class, 'index'])->name('admins.index');
        Route::get('admins/create',    [App\Http\Controllers\MasterAdmin\AdminController::class, 'create'])->name('admins.create');
        Route::post('admins',          [App\Http\Controllers\MasterAdmin\AdminController::class, 'store'])->name('admins.store');
        Route::delete('admins/{user}', [App\Http\Controllers\MasterAdmin\AdminController::class, 'destroy'])->name('admins.destroy');

    });

require __DIR__.'/auth.php';
