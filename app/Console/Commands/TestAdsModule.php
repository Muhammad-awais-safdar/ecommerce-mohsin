<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Console\Command;

class TestAdsModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the ads module functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing Ads Module...');
        $this->newLine();

        // Test 1: Check database connection and Ad model
        $this->info('📊 Test 1: Checking database and model...');
        try {
            $totalAds = Ad::count();
            $activeAds = Ad::active()->count();
            $this->info("✅ Database connection: OK");
            $this->info("✅ Total ads in database: {$totalAds}");
            $this->info("✅ Active ads: {$activeAds}");
        } catch (\Exception $e) {
            $this->error("❌ Database/Model error: " . $e->getMessage());
            return 1;
        }
        $this->newLine();

        // Test 2: Check AdService
        $this->info('🛠️ Test 2: Testing AdService...');
        try {
            $adService = app(AdService::class);
            $randomAd = $adService->getRandomActiveAd();
            
            if ($randomAd) {
                $this->info("✅ AdService working: Found ad '{$randomAd->title}'");
                $this->info("✅ Ad image URL: " . ($randomAd->image_url ?? 'No image'));
                $this->info("✅ Ad has valid image: " . ($randomAd->hasValidImage() ? 'Yes' : 'No'));
            } else {
                $this->warn("⚠️ No active ads found with valid images");
            }

            // Test route exclusion
            $shouldShow = $adService->shouldShowAdsOnRoute('home');
            $shouldNotShow = $adService->shouldShowAdsOnRoute('checkout');
            $this->info("✅ Route filtering: Home=" . ($shouldShow ? 'Show' : 'Hide') . ", Checkout=" . ($shouldNotShow ? 'Show' : 'Hide'));
        } catch (\Exception $e) {
            $this->error("❌ AdService error: " . $e->getMessage());
            return 1;
        }
        $this->newLine();

        // Test 3: Check component files
        $this->info('📄 Test 3: Checking component files...');
        $modalComponent = resource_path('views/components/ad-modal.blade.php');
        $bannerComponent = resource_path('views/components/ad-banner.blade.php');
        
        if (file_exists($modalComponent)) {
            $this->info("✅ Modal component exists: {$modalComponent}");
        } else {
            $this->error("❌ Modal component missing: {$modalComponent}");
        }
        
        if (file_exists($bannerComponent)) {
            $this->info("✅ Banner component exists: {$bannerComponent}");
        } else {
            $this->error("❌ Banner component missing: {$bannerComponent}");
        }
        $this->newLine();

        // Test 4: Analytics summary
        $this->info('📈 Test 4: Analytics summary...');
        try {
            $analytics = $adService->getAnalyticsSummary();
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Ads', $analytics['total_ads']],
                    ['Active Ads', $analytics['active_ads']],
                    ['Inactive Ads', $analytics['inactive_ads']],
                    ['Expired Ads', $analytics['expired_ads']],
                    ['Total Views', number_format($analytics['total_views'])],
                    ['Total Clicks', number_format($analytics['total_clicks'])],
                    ['Average CTR', $analytics['average_ctr'] . '%'],
                ]
            );
        } catch (\Exception $e) {
            $this->error("❌ Analytics error: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 Ads module testing completed!');
        
        // Provide recommendations
        $this->newLine();
        $this->info('💡 Recommendations:');
        if ($activeAds === 0) {
            $this->warn('• Create some active ads through the admin panel');
        }
        if ($totalAds > 0 && $randomAd === null) {
            $this->warn('• Ensure ads have custom images uploaded');
        }
        $this->info('• Test the modal popup by visiting your website');
        $this->info('• Check the admin panel at /admin/ads for management');

        return 0;
    }
}
