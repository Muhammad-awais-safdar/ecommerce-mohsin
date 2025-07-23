<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ShopController extends Controller
{
    // GET /api/products
    public function index(Request $request)
    {
        // If the user wants highlights instead of paginated list
        if ($request->query('highlighted') === 'true') {
            return response()->json([
                'deal_of_the_day' => ProductResource::collection(
                    Product::with(['details', 'stock', 'reviews'])
                        ->where('is_deal', true)
                        ->latest()
                        ->take(10)
                        ->get()
                ),
                'top_rated' => ProductResource::collection(
                    Product::with(['details', 'stock', 'reviews'])
                        ->withCount('reviews') // Adds `reviews_count` to each product
                        ->orderByDesc('reviews_count')
                        ->take(10)
                        ->get()
                ),
                'new_arrivals' => ProductResource::collection(
                    Product::with(['details', 'stock', 'reviews'])
                        ->latest()
                        ->take(10)
                        ->get()
                ),
                'best_sellers' => ProductResource::collection(
                    Product::with(['details', 'stock', 'reviews'])
                        ->orderByDesc('sales_count')
                        ->take(10)
                        ->get()
                ),
            ]);
        }

        // Default: paginated product list
        $products = Product::with(['details', 'stock', 'reviews'])->latest()->paginate(12);
        return ProductResource::collection($products);
    }


    // GET /api/products/{slug}
    public function show($slug)
    {
        $product = Product::with(['details', 'stock', 'reviews'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new ProductResource($product);
    }
}
