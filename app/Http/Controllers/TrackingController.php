<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrackingController extends Controller
{
    // public function trackOrderForm()
    // {
    //     return view('Ecommerce.track.form');
    // }

    // public function trackOrder(Request $request)
    // {
    //     $request->validate([
    //         'tracking_number' => 'required|string',
    //     ]);

    //     $trackingNumber = $request->tracking_number;

    //     // Example: Fetch order by tracking number
    //     $order = Order::where('tracking_number', $trackingNumber)->first();

    //     if (!$order) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No order found with this tracking number.',
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'tracking_status' => $order->tracking_status, // Example: processing, in_transit, delivered, failed
    //             'status' => $order->status, // Example: paid, pending, failed
    //         ],
    //     ]);
    // }
}
