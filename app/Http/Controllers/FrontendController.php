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
            ->take(8)
            ->get();
        return view('Ecommerce.Mainindex', compact('products', 'allproducts'));
    }
    public function shop()
    {
        $products = Product::paginate(12);
        return view('Ecommerce.pages.shop', compact('products'));
    }

    public function show($slug, SeoService $seoService)
    {
        $product = Product::with(['reviews'])->where('slug', $slug)->firstOrFail(); // returns a single model

        $allproducts = Product::withCount('reviews')
            ->where('id', '!=', $product->id)
            ->get();

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
