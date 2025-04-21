<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{

    public function form()
    {
        $cart = session('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return view('Ecommerce.pages.checkout', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string|max:10',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_name' => $request->first_name . ' ' . $request->last_name,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->state . ', ' . $request->country . ' - ' . $request->zip,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('checkout.payment', ['order_id' => $order->id])->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

public function payment(Request $request)
{
     $orderId = $request->query('order_id');

    $order = Order::findOrFail($orderId);

    $accessToken = 'your_revolut_access_token'; // Replace with your token

    $response = Http::withToken($accessToken)->post('https://merchant.revolut.com/api/1.0/orders', [
        'amount' => $order->total_amount * 100, // Amount in cents
        'currency' => 'USD',
        'merchant_order_ext_ref' => 'ORDER_' . $order->id,
        'capture_mode' => 'AUTOMATIC',
        'description' => 'Payment for Order #' . $order->id,
        'customer_email' => 'test@example.com', // Replace if you have email field
        'success_url' => url('/payment/success'),
        'failure_url' => url('/payment/failure'),
    ]);

    if ($response->successful()) {
        return redirect($response['checkout_url']);
    } else {
        return back()->with('error', 'Failed to initialize payment: ' . json_encode($response->json()));
    }
}

}