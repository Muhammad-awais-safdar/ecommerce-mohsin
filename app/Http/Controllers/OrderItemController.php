<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // View order items of a specific order
    public function show($orderId)
    {
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        return view('order.show', compact('orderItems'));
    }

    // Optionally, you can handle additional order item actions here, like updating or removing
}