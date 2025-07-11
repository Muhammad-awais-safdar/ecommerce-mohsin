<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\RefundRequestController;


if (app()->environment('local', 'staging')) {
    require __DIR__ . '/artisan.php';
}



// Order tracking
// Route::get('/track-order', [TrackingController::class, 'trackOrderForm'])->name('order.track.form');
// Route::post('/track-order', [TrackingController::class, 'trackOrder'])->name('order.track');

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [FrontendController::class, 'show'])->name('product.show');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/reviews', [FrontendController::class, 'reviews'])->name('reviews.store');

// Route::get('/', [CartController::class, 'index']);
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addtocart');
Route::get('/cart', [CartController::class, 'showCart'])->name('showCart');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'updateItem'])->name('cart.update');


Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
// Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/buy-now', [CheckoutController::class, 'checkout'])->name('buy.now');



Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');


Route::get('/refund-request', [RefundRequestController::class, 'create'])->name('refund.request.form');
Route::post('/refund-request', [RefundRequestController::class, 'store'])->name('refund.request.store');




Route::fallback(function () {
    return view('Ecommerce.pages.404page');
});


Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');







// routes/web.php

Route::get('/robots.txt', function () {
    $robots = SiteSetting::first()?->robots_txt ?? "User-agent: *\nDisallow:";
    return response($robots, 200)->header('Content-Type', 'text/plain');
});


// offer //
// routes/web.php
Route::post('/make-offer', [OfferController::class, 'store'])->name('make.offer');


// order reciept
Route::get('/order/{order}/receipt', [OrderReceiptController::class, 'downloadPdfReceipt'])->name('order.receipt.download');
Route::get('/download-receipt-image/{orderId}', [OrderReceiptController::class, 'downloadReceiptImage'])->name('order.receipt.download.img');
