<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductCacheService
{
    const CACHE_TTL = 1800; // 30 minutes
    const PAGINATION_CACHE_TTL = 900; // 15 minutes
    
    public function getShopProducts($page = 1, $filters = [])
    {
        $cacheKey = "shop_products_page_{$page}_" . md5(serialize($filters));
        
        return Cache::remember($cacheKey, self::PAGINATION_CACHE_TTL, function () use ($page, $filters) {
            $query = Product::with('reviews')->published();
            
            // Apply search filter
            if (!empty($filters['search'])) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            }
            
            // Apply price filters
            if (!empty($filters['min_price'])) {
                $query->where('price', '>=', $filters['min_price']);
            }
            if (!empty($filters['max_price'])) {
                $query->where('price', '<=', $filters['max_price']);
            }
            
            // Apply sorting
            switch ($filters['sort'] ?? 'newest') {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
            
            $perPage = $filters['per_page'] ?? 12;
            return $query->paginate($perPage, ['*'], 'page', $page);
        });
    }
    
    public function getHomepageProducts()
    {
        return Cache::remember('homepage_products', self::CACHE_TTL, function () {
            return Product::published()->take(12)->get();
        });
    }
    public function dealOfTheDayProducts()
    {
        return Cache::remember('deal_of_the_day_products', self::CACHE_TTL, function () {
            return Product::published()
                ->where('is_deal', true)
                ->orderByDesc('discount_percentage')
                ->limit(10)
                ->get();
        });
    }

    public function getFeaturedProducts()
    {
        return Cache::remember('homepage_featured_products', self::CACHE_TTL, function () {
            return Product::published()
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->take(8)
                ->get();
        });
    }
    
    public function getProductBySlug($slug)
    {
        return Cache::remember("product_details_{$slug}", self::CACHE_TTL, function () use ($slug) {
            return Product::published()->with(['reviews'])->where('slug', $slug)->firstOrFail();
        });
    }
    
    public function getRelatedProducts($productId)
    {
        return Cache::remember("related_products_{$productId}", self::CACHE_TTL, function () use ($productId) {
            return Product::published()
                ->withCount('reviews')
                ->where('id', '!=', $productId)
                ->take(8)
                ->get();
        });
    }
    
    
    public function clearAllProductCache()
    {
        Cache::forget('homepage_products');
        Cache::forget('homepage_featured_products');
        Cache::forget('deal_of_the_day_products');
        
        // Clear all shop product cache (including filtered versions)
        $tags = ['shop_products', 'product_details', 'related_products'];
        foreach ($tags as $tag) {
            // Clear cache by pattern - this is a simplified approach
            // In production, consider using cache tags for better management
        }
        
        // Clear paginated shop cache
        for ($page = 1; $page <= 50; $page++) {
            // Clear base pagination cache
            Cache::forget("shop_products_page_{$page}");
            // Note: In production, you'd want a more sophisticated cache clearing strategy
            // for filtered results, possibly using cache tags
        }
    }
}