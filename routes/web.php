<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RefundRequestController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;










Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [FrontendController::class, 'show'])->name('product.show');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');


// Route::get('/', [CartController::class, 'index']);
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addtocart');
Route::get('/cart', [CartController::class, 'showCart'])->name('showCart');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'updateItem'])->name('cart.update');


Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
// Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');


Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');



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




Route::get('/refund-request', [RefundRequestController::class, 'create'])->name('refund.request.form');
Route::post('/refund-request', [RefundRequestController::class, 'store'])->name('refund.request.store');




Route::fallback(function () {
    return view('Ecommerce.pages.404page');
});


Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');