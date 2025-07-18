<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\ProductCacheService;

class WarmProductCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 minutes timeout

    public function handle(ProductCacheService $cacheService): void
    {
        try {
            Log::info('Starting product cache warming job');
            
            // Warm homepage products
            $cacheService->getHomepageProducts();
            Log::info('Homepage products cached');

            // Warm featured products
            $cacheService->getFeaturedProducts();
            Log::info('Featured products cached');

            // Warm first few pages of shop
            for ($page = 1; $page <= 3; $page++) {
                $cacheService->getShopProducts($page);
                Log::info("Shop page {$page} cached");
            }

            Log::info('Product cache warming completed successfully');
            
        } catch (\Throwable $e) {
            Log::error('Failed to warm product cache in job', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}