<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/checkout', [ProductController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{product}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::get('/orders/{order}',[OrderController::class, 'show'])->middleware('auth')->name('orders.show');

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

require __DIR__.'/auth.php';
