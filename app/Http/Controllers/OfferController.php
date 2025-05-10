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
            'offer_price' => 'required|numeric|min:1',
            'email' => 'nullable|email',
        ]);

        $offer = Offer::create([
            'product_id' => $request->product_id,
            'session_id' => session()->getId(),
            'email' => $request->email,
            'offer_price' => $request->offer_price,
        ]);

        return response()->json(['message' => 'Offer submitted successfully.']);
    }
}
