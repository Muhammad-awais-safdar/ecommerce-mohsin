<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdService
{
    /**
     * Get a random active ad with caching
     */
    public function getRandomActiveAd(): ?Ad
    {
        try {
            // Cache active ads for 5 minutes to improve performance
            $activeAds = Cache::remember('active_ads', 300, function () {
                return Ad::active()
                    ->with('product')
                    ->whereNotNull('custom_image')
                    ->get()
                    ->filter(function ($ad) {
                        // Ensure ad has a valid image URL
                        return $ad->hasValidImage();
                    });
            });

            if ($activeAds->isEmpty()) {
                return null;
            }

            return $activeAds->random();

        } catch (\Exception $e) {
            Log::error('Failed to get random active ad', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    /**
     * Get multiple random active ads
     */
    public function getRandomActiveAds(int $count = 3): Collection
    {
        try {
            $activeAds = Cache::remember('active_ads', 300, function () {
                return Ad::active()
                    ->with('product')
                    ->whereNotNull('custom_image')
                    ->get()
                    ->filter(function ($ad) {
                        // Ensure ad has a valid image URL
                        return $ad->hasValidImage();
                    });
            });

            return $activeAds->random(min($count, $activeAds->count()));

        } catch (\Exception $e) {
            Log::error('Failed to get random active ads', [
                'count' => $count,
                'error' => $e->getMessage(),
            ]);

            return collect();
        }
    }

    /**
     * Clear the active ads cache
     */
    public function clearCache(): void
    {
        Cache::forget('active_ads');
    }

    /**
     * Get ads analytics summary
     */
    public function getAnalyticsSummary(): array
    {
        try {
            $totalAds = Ad::count();
            $activeAds = Ad::active()->count();
            $expiredAds = Ad::expired()->count();
            $totalViews = Ad::sum('views');
            $totalClicks = Ad::sum('clicks');
            $avgCtr = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 2) : 0;

            return [
                'total_ads' => $totalAds,
                'active_ads' => $activeAds,
                'expired_ads' => $expiredAds,
                'inactive_ads' => $totalAds - $activeAds,
                'total_views' => $totalViews,
                'total_clicks' => $totalClicks,
                'average_ctr' => $avgCtr,
                'best_performing_ad' => Ad::where('views', '>', 0)
                    ->orderByRaw('(clicks / views) DESC')
                    ->first(),
            ];

        } catch (\Exception $e) {
            Log::error('Failed to get ads analytics summary', [
                'error' => $e->getMessage(),
            ]);

            return [
                'total_ads' => 0,
                'active_ads' => 0,
                'expired_ads' => 0,
                'inactive_ads' => 0,
                'total_views' => 0,
                'total_clicks' => 0,
                'average_ctr' => 0,
                'best_performing_ad' => null,
            ];
        }
    }

    /**
     * Check if ads should be shown on current route
     */
    public function shouldShowAdsOnRoute(?string $routeName): bool
    {
        $excludedRoutes = [
            'checkout',
            'checkout.store', 
            'checkout.payment',
            'payment.success',
            'payment.failure',
        ];

        return !in_array($routeName, $excludedRoutes);
    }

    /**
     * Track ad impression (view)
     */
    public function trackImpression(Ad $ad): bool
    {
        try {
            if ($ad->is_active && !$ad->is_expired) {
                $ad->incrementViews();
                
                // Clear cache after tracking to ensure fresh data
                $this->clearCache();
                
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Failed to track ad impression', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Track ad click
     */
    public function trackClick(Ad $ad): bool
    {
        try {
            if ($ad->is_active && !$ad->is_expired) {
                $ad->incrementClicks();
                
                // Clear cache after tracking to ensure fresh data
                $this->clearCache();
                
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Failed to track ad click', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}