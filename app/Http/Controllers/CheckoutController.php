<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function form()
    {
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'shipping_address' => 'required',
        ]);

        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'shipping_address' => $data['shipping_address'],
            'total_amount' => $total,
            'status' => 'pending',
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        return redirect('/')->with('success', 'Order placed!');
    }

}