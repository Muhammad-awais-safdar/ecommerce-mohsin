<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderItemController;




Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/product/{id}', [FrontendController::class, 'show'])->name('product.show');

// // Admin routes
// Route::get('/admin/products', [ProductController::class, 'admin'])->name('admin.products');
// Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
// Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');







// // Cart Routes
// Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
// Route::post('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');

// // CartItem Routes
// Route::post('/cart-item/update/{cartItemId}', [CartItemController::class, 'update'])->name('cart-item.update');

// // Order Routes
// Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.form');
// Route::post('/checkout', [OrderController::class, 'process'])->name('checkout.process');

// // OrderItem Routes (Optional, for viewing)
// Route::get('/order/{orderId}', [OrderItemController::class, 'show'])->name('order.show');




Route::get('/run-migrate', function () {

    // Run migrate
    Artisan::call('migrate', ['--force' => true]);
    return response()->json([
        'status' => 'success',
        'message' => 'Migration and seeding executed successfully.'
    ]);
});
Route::get('/run-seed', function () {
    // Run seed
    Artisan::call('db:seed', ['--force' => true]);

    return response()->json([
        'status' => 'success',
        'message' => 'Migration and seeding executed successfully.'
    ]);
});