<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        // Logic to fetch and display products
        return view('Ecommerce.Mainindex');
    }
    
     public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.show', compact('product'));
    }
}