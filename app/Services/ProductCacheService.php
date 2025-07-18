<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductCacheService
{
    const CACHE_TTL = 1800; // 30 minutes
    const PAGINATION_CACHE_TTL = 900; // 15 minutes
    
    public function getShopProducts($page = 1)
    {
        $cacheKey = "shop_products_page_{$page}";
        
        return Cache::remember($cacheKey, self::PAGINATION_CACHE_TTL, function () {
            $query = Product::with('reviews');
            $query->orderBy('created_at', 'desc');
            
            return $query->paginate(12);
        });
    }
    
    public function getHomepageProducts()
    {
        return Cache::remember('homepage_products', self::CACHE_TTL, function () {
            return Product::get();
        });
    }
    
    public function getFeaturedProducts()
    {
        return Cache::remember('homepage_featured_products', self::CACHE_TTL, function () {
            return Product::withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->take(8)
                ->get();
        });
    }
    
    public function getProductBySlug($slug)
    {
        return Cache::remember("product_details_{$slug}", self::CACHE_TTL, function () use ($slug) {
            return Product::with(['reviews'])->where('slug', $slug)->firstOrFail();
        });
    }
    
    public function getRelatedProducts($productId)
    {
        return Cache::remember("related_products_{$productId}", self::CACHE_TTL, function () use ($productId) {
            return Product::withCount('reviews')
                ->where('id', '!=', $productId)
                ->get();
        });
    }
    
    
    public function clearAllProductCache()
    {
        Cache::forget('homepage_products');
        Cache::forget('homepage_featured_products');
        
        // Clear paginated shop cache
        for ($page = 1; $page <= 20; $page++) {
            Cache::forget("shop_products_page_{$page}");
        }
    }
}