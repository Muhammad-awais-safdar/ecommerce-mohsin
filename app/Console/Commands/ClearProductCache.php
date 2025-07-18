<?php

namespace App\Console\Commands;

use App\Services\ProductCacheService;
use Illuminate\Console\Command;

class ClearProductCache extends Command
{
    protected $signature = 'cache:clear-products';
    protected $description = 'Clear all product-related cache';

    public function handle(ProductCacheService $cacheService)
    {
        $cacheService->clearAllProductCache();
        $this->info('Product cache cleared successfully!');
    }
}