<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use GuzzleHttp\Client;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Checkout form
    public function checkout()
    {
        $cart = Auth::user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('cart.checkout', compact('cart'));
    }

    // Process the order and initiate payment
    public function process(Request $request)
    {
        // Validate user input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_address' => 'nullable|string',
        ]);

        // Get the cart
        $cart = Auth::user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total amount
        $totalAmount = 0;
        foreach ($cart->items as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'total_amount' => $totalAmount
        ]);

        // Create order items from cart items
        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);
        }

        // Make payment request to Revolut
        $client = new Client();
        $response = $client->post(config('services.revolut.api_url'), [
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.revolut.api_key'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $totalAmount, // Amount in cents or currency smallest unit
                'currency' => 'USD',
                'order_reference' => $order->id,
                'description' => 'Order Payment',
                'return_url' => route('payment.success', $order->id),
                'cancel_url' => route('payment.cancel', $order->id),
            ]
        ]);

        $data = json_decode($response->getBody()->getContents());

        // Redirect to Revolut payment page
        if ($data->status === 'success') {
            return redirect($data->payment_url); // Assuming Revolut returns the payment URL
        }

        return redirect()->route('cart.index')->with('error', 'Payment initiation failed.');
    }

    // Handle successful payment callback
    public function paymentSuccess($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'paid']);

        // Clear the cart
        $cart = Auth::user()->cart;
        $cart->items()->delete();

        return redirect()->route('home')->with('success', 'Your order has been successfully paid!');
    }

    // Handle failed payment callback
    public function paymentCancel($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'cancelled']);

        return redirect()->route('cart.index')->with('error', 'Your payment was cancelled.');
    }
}
