<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;








Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/product/{id}', [FrontendController::class, 'show'])->name('product.show');



Route::get('/', [CartController::class, 'index']);
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'showCart']);
Route::post('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);

Route::get('/checkout', [CheckoutController::class, 'form']);
Route::post('/checkout', [CheckoutController::class, 'process']);




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