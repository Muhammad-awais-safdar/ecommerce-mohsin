<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Console\Command;

class TestModal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:test-modal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test modal functionality and provide debugging info';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing Ad Modal Functionality...');
        $this->newLine();

        // Test ad availability
        $adService = app(AdService::class);
        $ad = $adService->getRandomActiveAd();
        
        if (!$ad) {
            $this->error('❌ No active ads found!');
            $this->info('💡 Create an ad in the admin panel first.');
            return 1;
        }

        $this->info("✅ Found ad: '{$ad->title}'");
        $this->info("📷 Image URL: {$ad->image_url}");
        $this->info("🔗 Button Link: {$ad->button_link}");
        $this->newLine();

        // Test route filtering
        $this->info('🛣️ Testing route filtering...');
        $testRoutes = ['home', 'shop', 'checkout', 'payment.success'];
        foreach ($testRoutes as $route) {
            $shouldShow = $adService->shouldShowAdsOnRoute($route);
            $status = $shouldShow ? '✅ Show' : '❌ Hide';
            $this->line("  {$route}: {$status}");
        }
        $this->newLine();

        // Test component files
        $this->info('📄 Checking component files...');
        $simpleModal = resource_path('views/components/ad-modal-simple.blade.php');
        $bootstrapModal = resource_path('views/components/ad-modal.blade.php');
        
        $this->line('  Simple Modal: ' . (file_exists($simpleModal) ? '✅ Exists' : '❌ Missing'));
        $this->line('  Bootstrap Modal: ' . (file_exists($bootstrapModal) ? '✅ Exists' : '❌ Missing'));
        $this->newLine();

        // Provide debugging instructions
        $this->info('🐛 Debugging Instructions:');
        $this->line('1. Visit: ' . url('/test-ads'));
        $this->line('2. Open browser console (F12)');
        $this->line('3. Look for "🎯 Simple Ad Modal Loading..." message');
        $this->line('4. Wait 5 seconds for modal to appear');
        $this->line('5. Check HTML source for debug comments');
        $this->newLine();

        // Test session storage clearing
        $this->info('🧹 Session Storage Key:');
        $this->line("  Key: simpleAdModal_{$ad->id}_shown_today");
        $this->line('  Clear this in browser console if modal not showing:');
        $this->line("  sessionStorage.removeItem('simpleAdModal_{$ad->id}_shown_today')");
        $this->newLine();

        $this->info('🎉 Modal test information ready!');
        return 0;
    }
}
