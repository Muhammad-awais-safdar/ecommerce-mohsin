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
            'product_id'    => 'required|exists:products,id',
            'offered_price' => 'required|numeric|min:0.01',
            'contact_info'  => 'required|string'
        ]);

        Offer::create([
            'session_id'    => session()->getId(),
            'product_id'    => $request->product_id,
            'offered_price' => $request->offered_price,
            'contact_info'  => $request->contact_info,
        ]);

        return response()->json([
            'message' => 'Your offer has been submitted! We will contact you soon.'
        ]);
    }
}
