<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceiptMail;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $orderId = $request->query('order_id');

        $order = Order::with('orderItems.product')->find($orderId);

        if (!$order) {
            return redirect('/')->with('error', 'Order not found.');
        }

        $order->status = 'paid';
        $order->save();

        // Send Email to Customer
        Mail::to($order->customer_email)->send(new OrderReceiptMail($order));

        // Send Email to Admin
        Mail::to(env('ADMIN_EMAIL'))->send(new OrderReceiptMail($order));

        return view('Ecommerce.payment.success', compact('order'))->with('success', 'Payment successful! Your order is confirmed and receipt has been emailed.');
    }

    public function paymentFailure(Request $request)
    {
        $orderId = $request->query('order_id');

        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'failed'; // Optional: Or you can keep it 'pending'
            $order->save();
        }

        return view('Ecommerce.payment.failure')->with('error', 'Payment failed or canceled. Please try again.');
    }

}