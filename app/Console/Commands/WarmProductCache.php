<?php

namespace App\Console\Commands;

use App\Services\ProductCacheService;
use Illuminate\Console\Command;

class WarmProductCache extends Command
{
    protected $signature = 'cache:warm-products';
    protected $description = 'Warm up product cache';

    public function handle(ProductCacheService $cacheService)
    {
        $this->info('Warming product cache...');
        
        // Warm homepage products
        $cacheService->getHomepageProducts();
        $this->info('Homepage products cached');
        
        // Warm featured products
        $cacheService->getFeaturedProducts();
        $this->info('Featured products cached');
        
        // Warm first few pages of shop
        for ($page = 1; $page <= 5; $page++) {
            $cacheService->getShopProducts($page);
            $this->info("Shop page {$page} cached");
        }
        
        $this->info('Product cache warmed successfully!');
    }
}