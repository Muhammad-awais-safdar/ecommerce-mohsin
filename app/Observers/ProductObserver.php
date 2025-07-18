<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ProductCacheService;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function created(Product $product)
    {
        $this->clearProductCache($product);
    }

    public function updated(Product $product)
    {
        $this->clearProductCache($product);
        Cache::forget("product_details_{$product->slug}");
        Cache::forget("related_products_{$product->id}");
    }

    public function deleted(Product $product)
    {
        $this->clearProductCache($product);
        Cache::forget("product_details_{$product->slug}");
        Cache::forget("related_products_{$product->id}");
    }

    private function clearProductCache(Product $product)
    {
        $cacheService = app(ProductCacheService::class);
        $cacheService->clearAllProductCache();
    }
}