<?php

// app/Http/Controllers/OfferController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'offer_price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
        ]);

        Offer::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'offer_price' => $request->offer_price,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your offer has been submitted!');
    }
}
