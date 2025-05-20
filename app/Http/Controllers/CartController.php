<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $discount = $product->discount_percentage ?? 0;

        // Apply discount if any
        $finalPrice = $product->price;
        if ($discount > 0) {
            $finalPrice = $product->price - ($product->price * ($discount / 100));
        }

        $cart = session()->get('cart', []);
        $firstImage = $product->images[0] ?? 'default.jpg';
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $finalPrice,
                'original_price' => $product->price,
                'discount' => $discount,
                'quantity' => 1,
                'image' => $firstImage,
            ];
        }

        // dd($cart);
        session()->put('cart', $cart);

        $count = array_sum(array_map(fn($item) => $item['quantity'] ?? 0, $cart));

        $subtotal = 0;
        foreach ($cart as $item) {
            $qty = $item['quantity'] ?? 0;
            $price = $item['price'] ?? 0;
            $subtotal += $price * $qty;
        }

        return response()->json([
            'status' => 'success',
            'message' => "{$product->name} added to cart!",
            'cart_count' => $count,
            'subtotal' => '$' . number_format($subtotal, 2),
        ]);
    }




    public function showCart()
    {
        $cart = session('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('Ecommerce.pages.shoppingcart', compact('cart', 'subtotal'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $count = array_sum(array_map(function ($item) {
                return $item['quantity'] ?? 0;
            }, $cart));
            return response()->json(['success' => true, 'cart_count' => $count, 'message' => 'Item removed from cart']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart'], 404);
    }

    public function updateItem(Request $request, $id)
    {
        $quantity = (int) $request->quantity;

        if (session()->has('cart')) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);

                $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
                $subtotal = collect($cart)->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                });

                return response()->json([
                    'success' => true,
                    'item_total' => number_format($itemTotal, 2),
                    'subtotal' => number_format($subtotal, 2)
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
