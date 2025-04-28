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
        // Validate input
        $req->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'reason' => 'required|string|min:10',
        ]);

        $checkRefund = RefundRequest::where('order_id', $req->order_id)->first();

        if ($checkRefund) {
            return response()->json([
                'success' => false,
                'message' => 'No repeat of refund request allowed for this order.',
            ], 422);
        }
        try {
            $order = Order::findOrFail($req->order_id);

            // Verify email/phone match
            if ($order->customer_email !== $req->customer_email || $order->customer_phone !== $req->customer_phone) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order details do not match.',
                ], 422);
            }

            // Create refund request
            RefundRequest::create([
                'order_id' => $order->id,
                'customer_name' => $order->customer_name,
                'customer_email' => $req->customer_email,
                'customer_phone' => $req->customer_phone,
                'reason' => $req->reason,
            ]);

            // Notify admin
            Mail::to(env('ADMIN_EMAIL'))->send(new RefundRequestMail($order, 'pending'));

            return response()->json([
                'success' => true,
                'message' => 'Refund request submitted successfully!',
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }


}