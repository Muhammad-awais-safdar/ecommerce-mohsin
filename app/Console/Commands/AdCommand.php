<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AdCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'ads:manage {action : The action to perform (clear-cache, expire-check, stats)}';

    /**
     * The console command description.
     */
    protected $description = 'Manage advertisements and their cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $adService = app(AdService::class);

        switch ($action) {
            case 'clear-cache':
                $adService->clearCache();
                $this->info('✅ Ad cache cleared successfully!');
                break;

            case 'expire-check':
                $expiredCount = $this->checkExpiredAds();
                $this->info("✅ Checked for expired ads. Found {$expiredCount} expired ads.");
                break;

            case 'stats':
                $this->showStats($adService);
                break;

            default:
                $this->error('❌ Invalid action. Available actions: clear-cache, expire-check, stats');
                return 1;
        }

        return 0;
    }

    /**
     * Check for expired ads and optionally deactivate them
     */
    private function checkExpiredAds(): int
    {
        $expiredAds = Ad::where('expires_at', '<=', now())
            ->where('is_active', true)
            ->get();

        if ($expiredAds->isEmpty()) {
            $this->info('No expired ads found.');
            return 0;
        }

        $this->table(
            ['ID', 'Title', 'Expired At', 'Views', 'Clicks', 'CTR'],
            $expiredAds->map(function ($ad) {
                return [
                    $ad->id,
                    $ad->title,
                    $ad->expires_at->format('Y-m-d H:i:s'),
                    $ad->views,
                    $ad->clicks,
                    $ad->click_through_rate . '%'
                ];
            })
        );

        if ($this->confirm('Do you want to deactivate these expired ads?')) {
            $expiredAds->each(function ($ad) {
                $ad->update(['is_active' => false]);
            });

            $this->info("✅ Deactivated {$expiredAds->count()} expired ads.");
            
            // Clear cache after updating
            app(AdService::class)->clearCache();
        }

        return $expiredAds->count();
    }

    /**
     * Show ad statistics
     */
    private function showStats(AdService $adService): void
    {
        $analytics = $adService->getAnalyticsSummary();

        $this->info('📊 Ad Statistics Summary');
        $this->line('═══════════════════════');

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

        if ($analytics['best_performing_ad']) {
            $bestAd = $analytics['best_performing_ad'];
            $this->info('🏆 Best Performing Ad:');
            $this->line("   • Title: {$bestAd->title}");
            $this->line("   • Views: {$bestAd->views}");
            $this->line("   • Clicks: {$bestAd->clicks}");
            $this->line("   • CTR: {$bestAd->click_through_rate}%");
        }

        // Show recent activity
        $recentAds = Ad::orderBy('created_at', 'desc')->take(5)->get();
        if ($recentAds->isNotEmpty()) {
            $this->info('📅 Recent Ads:');
            $this->table(
                ['ID', 'Title', 'Status', 'Views', 'Clicks', 'Created'],
                $recentAds->map(function ($ad) {
                    return [
                        $ad->id,
                        Str::limit($ad->title, 30),
                        $ad->status_text,
                        $ad->views,
                        $ad->clicks,
                        $ad->created_at->format('M d, Y'),
                    ];
                })
            );
        }
    }
}