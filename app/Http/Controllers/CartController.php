<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

public function index() {
    $products = Product::all();
    return view('welcome', compact('products'));
}

public function addToCart($id) {
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
        ];
    }

    session()->put('cart', $cart);
    return redirect('/cart');
}

public function showCart() {
    $cart = session('cart', []);
    return view('cart', compact('cart'));
}

public function removeFromCart($id) {
    $cart = session()->get('cart', []);
    unset($cart[$id]);
    session()->put('cart', $cart);
    return back();
}

}