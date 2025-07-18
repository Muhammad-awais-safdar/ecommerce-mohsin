<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductCacheService
{
    const CACHE_TTL = 1800; // 30 minutes
    const PAGINATION_CACHE_TTL = 900; // 15 minutes
    
    public function getShopProducts($page = 1, $filters = [])
    {
        $cacheKey = $this->generateShopCacheKey($page, $filters);
        
        return Cache::remember($cacheKey, self::PAGINATION_CACHE_TTL, function () use ($filters) {
            $query = Product::with('reviews');
            
            // Apply filters when they exist
            if (!empty($filters['search'])) {
                $query->where(function($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%');
                });
            }
            
            if (!empty($filters['min_price'])) {
                $query->where('price', '>=', $filters['min_price']);
            }
            
            if (!empty($filters['max_price'])) {
                $query->where('price', '<=', $filters['max_price']);
            }
            
            if (!empty($filters['sort'])) {
                switch ($filters['sort']) {
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'newest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }
            
            // Handle per_page parameter
            $perPage = !empty($filters['per_page']) ? (int)$filters['per_page'] : 12;
            $perPage = min($perPage, 24); // Cap at 24 items per page
            
            return $query->paginate($perPage);
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
            Cache::forget("shop_products_filtered_page_{$page}");
        }
    }
    
    private function generateShopCacheKey($page, $filters)
    {
        if (empty($filters)) {
            return "shop_products_page_{$page}";
        }
        
        $filterString = http_build_query($filters);
        return "shop_products_filtered_" . md5($filterString) . "_page_{$page}";
    }
}