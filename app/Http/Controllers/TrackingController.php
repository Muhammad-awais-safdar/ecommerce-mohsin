<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrackingController extends Controller
{
    public function trackOrderForm()
    {
        return view('Ecommerce.track.form');
    }

    public function trackOrder(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        $order = Order::where('tracking_number', $request->tracking_number)->first();

        if (!$order) {
            return back()->with('error', 'Tracking number not found.');
        }

        return view('Ecommerce.track.result', compact('order'));
    }
}
