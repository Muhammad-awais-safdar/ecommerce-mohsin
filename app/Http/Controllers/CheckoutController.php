<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Stripe\Checkout\Session;
// use App\Models\Order;
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
            'customer_email' => 'required|email|max:100',
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
                'customer_email' => $request->customer_email,
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
            dd($order);
            session()->forget('cart');

            return redirect()->route('checkout.payment', ['order_id' => $order->id])->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    public function payment(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::findOrFail($orderId);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $order->customer_email,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order #' . $order->id,
                            ],
                            'unit_amount' => $order->total_amount * 100, // in cents
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',

                'success_url' => route('payment.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.failure', ['order_id' => $order->id]),

                'metadata' => [
                    'order_id' => $order->id,
                    'customer_email' => $order->customer_email,
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }

}