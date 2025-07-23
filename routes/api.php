<?php

use App\Http\Controllers\api\v1\ContactController;
use App\Http\Controllers\api\v1\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/products', [ShopController::class, 'index']);

Route::get('/products/{slug}', [ShopController::class, 'show']);

Route::post('/contact', [ContactController::class, 'submit']);

Route::get('/seo/{pageName}', [ContactController::class, 'getMetaByPage']);
