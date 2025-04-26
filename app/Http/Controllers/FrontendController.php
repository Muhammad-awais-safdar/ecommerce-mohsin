<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return view('Ecommerce.Mainindex', compact('products'));
    }
    public function shop()
    {
        $products = Product::get();
        return view('Ecommerce.pages.shop', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.show', compact('product'));
    }
    public function about()
    {
        return view('Ecommerce.pages.about');
    }
    public function contact()
    {
        return view('Ecommerce.pages.contact');
    }
}