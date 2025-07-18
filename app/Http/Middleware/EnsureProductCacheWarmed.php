<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use App\Jobs\WarmProductCacheJob;

class EnsureProductCacheWarmed
{
    public function handle(Request $request, Closure $next)
    {
        // Check if any of the critical cache keys exist
        $criticalCacheKeys = [
            'homepage_products',
            'homepage_featured_products',
            'shop_products_page_1'
        ];
        
        $cacheExists = false;
        foreach ($criticalCacheKeys as $key) {
            if (Cache::has($key)) {
                $cacheExists = true;
                break;
            }
        }
        
        // If no cache exists, dispatch a job to warm it up
        if (!$cacheExists) {
            // Set a temporary flag to prevent multiple dispatches
            $lockKey = 'product_cache_warming_in_progress';
            
            if (!Cache::has($lockKey)) {
                Cache::put($lockKey, true, 300); // 5 minutes lock
                
                // Dispatch job to warm cache in background
                Queue::push(new WarmProductCacheJob());
            }
        }
        
        return $next($request);
    }
}