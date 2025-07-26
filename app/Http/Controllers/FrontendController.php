<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\EbayVerified;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\ProductCacheService;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{
    public function index(ProductCacheService $cacheService)
    {
        $ebayVerified = Cache::remember('ebay_verified', 3600, function () {
            return EbayVerified::all();
        });
        
        $products = $cacheService->getHomepageProducts();
        $DealOfTheproducts = $cacheService->dealOfTheDayProducts();
        $allproducts = $cacheService->getFeaturedProducts();
        
        $ebayVerified = Cache::remember('ebay_verified', 3600, function () {
            return EbayVerified::all();
        });
        
        $products = $cacheService->getHomepageProducts();
        $allproducts = $cacheService->getFeaturedProducts();
        
        return view('Ecommerce.Mainindex', compact('products', 'DealOfTheproducts', 'allproducts','ebayVerified'));
    }
    public function shop(Request $request, ProductCacheService $cacheService)
    {
        $page = $request->get('page', 1);
        $filters = $request->only(['search', 'min_price', 'max_price', 'sort', 'per_page', 'view']);
        
        $products = $cacheService->getShopProducts($page, $filters);
        
        if ($request->ajax()) {
            return response()->json([
                'products' => view('Ecommerce.partials.product-grid', compact('products'))->render(),
                'pagination' => $products->appends($filters)->links('vendor.pagination.default')->render()
            ]);
        }
        
        return view('Ecommerce.pages.shop', compact('products'));
    }

    public function show($slug, SeoService $seoService, ProductCacheService $cacheService)
    {
        $product = $cacheService->getProductBySlug($slug);
        $product->load('stock'); // Load stock relationship
        $allproducts = $cacheService->getRelatedProducts($product->id);

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
