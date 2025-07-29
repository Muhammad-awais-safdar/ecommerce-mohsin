<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AdController extends Controller
{
    /**
     * Track ad view
     */
    public function trackView(Request $request, Ad $ad): JsonResponse
    {
        try {
            // Only track views for active, non-expired ads
            if ($ad->is_active && !$ad->is_expired) {
                $ad->incrementViews();
                
                // Log the view for analytics
                Log::info('Ad view tracked', [
                    'ad_id' => $ad->id,
                    'ad_title' => $ad->title,
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referrer' => $request->header('referer'),
                ]);
            }

            return response()->json([
                'success' => true,
                'views' => $ad->fresh()->views,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to track ad view', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to track view',
            ], 500);
        }
    }

    /**
     * Track ad click
     */
    public function trackClick(Request $request, Ad $ad): JsonResponse
    {
        try {
            // Only track clicks for active, non-expired ads
            if ($ad->is_active && !$ad->is_expired) {
                $ad->incrementClicks();
                
                // Log the click for analytics
                Log::info('Ad click tracked', [
                    'ad_id' => $ad->id,
                    'ad_title' => $ad->title,
                    'button_link' => $ad->button_link,
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referrer' => $request->header('referer'),
                ]);
            }

            return response()->json([
                'success' => true,
                'clicks' => $ad->fresh()->clicks,
                'redirect_url' => $ad->button_link,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to track ad click', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to track click',
                'redirect_url' => $ad->button_link, // Still provide redirect URL
            ], 500);
        }
    }

    /**
     * Get random active ad (for AJAX loading)
     */
    public function getRandomAd(): JsonResponse
    {
        try {
            $ad = Ad::getRandomActiveAd();
            
            if (!$ad) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active ads available',
                ]);
            }

            return response()->json([
                'success' => true,
                'ad' => [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'image_url' => $ad->image_url,
                    'button_text' => $ad->button_text,
                    'button_link' => $ad->button_link,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get random ad', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load ad',
            ], 500);
        }
    }

    /**
     * Get ad analytics data
     */
    public function getAnalytics(Ad $ad): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'analytics' => [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'views' => $ad->views,
                    'clicks' => $ad->clicks,
                    'click_through_rate' => $ad->click_through_rate,
                    'is_active' => $ad->is_active,
                    'is_expired' => $ad->is_expired,
                    'expires_at' => $ad->expires_at?->toDateTimeString(),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get ad analytics', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load analytics',
            ], 500);
        }
    }
}