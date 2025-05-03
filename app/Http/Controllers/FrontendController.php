<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $allproducts = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->take(12)
            ->get();
        return view('Ecommerce.Mainindex', compact('products', 'allproducts'));
    }
    public function shop()
    {
        $products = Product::paginate(12);
        return view('Ecommerce.pages.shop', compact('products'));
    }

    public function show($id, SeoService $seoService)
    {
        // 1. Fetch the current product (with its reviews if you need them)
        $product = Product::with('reviews')->findOrFail($id);

        // 2. Get all other products (exclude the current one) with their review counts
        $allproducts = Product::withCount('reviews')
            ->whereNotIn('id', [$product->id])  // pass an array here
            ->get();
       
        // dd($seo);
        // 3. Return your view (no dd())
        return view('Ecommerce.pages.productdetails', compact('product', 'allproducts'));
    }

    public function about()
    {
        return view('Ecommerce.pages.about');
    }
    public function contact()
    {
        return view('Ecommerce.pages.contact');
    }
    public function reviews(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'author' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $review = Review::create([
            'product_id' => $data['product_id'],
            'user_name' => $data['author'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return response()->json([
            'message' => 'Your review has been submitted!',
            'review' => [
                'user_name' => $review->user_name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->format('F j, Y'),
            ],
        ]);
    }

}