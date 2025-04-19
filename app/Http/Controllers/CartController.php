<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show the user's cart
    public function index()
    {
        $cart = Auth::user()->cart;
        $cartItems = $cart ? $cart->items : [];
        return view('cart.index', compact('cartItems'));
    }

    // Add product to the cart
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Auth::user()->cart;

        // Check if the cart exists, if not, create it
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        // Check if the product is already in the cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // If the product is already in the cart, increase the quantity
            $cartItem->update(['quantity' => $cartItem->quantity + 1]);
        } else {
            // Otherwise, create a new cart item
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Remove item from the cart
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}