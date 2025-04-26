<?php

namespace App\Http\Controllers;

use App\Mail\RefundRequestMail;
use App\Models\Order;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class RefundRequestController extends Controller
{

    // app/Http/Controllers/RefundRequestController.php
    public function create()
    {
        return view('Ecommerce.pages.refund_request');
    }
    public function store(Request $req)
    {
        $req->validate([
            'order_id' => 'required|exists:orders,id',  // Order ID must exist in the orders table
            'customer_email' => 'required|email',  // Valid email format
            // 'customer_phone' => 'required|regex:/^(\+44|0)7\d{9}$/',  // Phone must be numeric and 10 digits
            'customer_phone' => 'required',  // Phone must be numeric and 10 digits
            'reason' => 'required|string|min:10',
        ]);
        $order = Order::findOrFail($req->order_id);
        // verify email/phone match:
        if ($order->customer_email !== $req->customer_email || $order->customer_phone !== $req->customer_phone) {
            return back()->with('error', 'Order details do not match.');
        }
        RefundRequest::create([
            'order_id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_email' => $req->customer_email,
            'customer_phone' => $req->customer_phone,
            'reason' => $req->reason,
        ]);
        // notify admin
        Mail::to(env('ADMIN_EMAIL'))->send(new RefundRequestMail($order, 'pending'));
        return response()->json([
            'success' => true,
            'message' => 'Refund request submitted successfully!'
        ]);
    }

}