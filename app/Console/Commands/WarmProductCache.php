<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ProductCacheService;

class WarmProductCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up product cache';

    /**
     * Execute the console command.
     *
     * @param ProductCacheService $cacheService
     * @return int
     */
    public function handle(ProductCacheService $cacheService): int
    {
        $this->info('Warming product cache...');

        try {
            // Warm homepage products
            $cacheService->getHomepageProducts();
            $this->info('✅ Homepage products cached');

            // Warm featured products
            $cacheService->getFeaturedProducts();
            $this->info('✅ Featured products cached');

            // Warm first few pages of shop
            for ($page = 1; $page <= 5; $page++) {
                $cacheService->getShopProducts($page);
                $this->info("✅ Shop page {$page} cached");
            }

            $this->info('🎉 Product cache warmed successfully!');
            Log::info('Product cache warm completed via artisan command.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('❌ Failed to warm product cache: ' . $e->getMessage());
            Log::error('Failed to warm product cache', ['exception' => $e]);
            return self::FAILURE;
        }
    }
}
