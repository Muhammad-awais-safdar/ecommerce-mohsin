<?php

namespace App\Services;

use Facebook\Facebook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FacebookAdService
{
    protected $fb;
    protected $accessToken;
    protected $adAccountId;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v19.0',
        ]);

        $this->accessToken = config('services.facebook.access_token');
        $this->adAccountId = config('services.facebook.ad_account_id');
    }

    public function isConfigured(): bool
    {
        return !empty($this->accessToken) && 
               !empty($this->adAccountId) && 
               config('services.facebook.app_id') !== 'your_facebook_app_id';
    }

    public function getAccountOverview(): array
    {
        if (!$this->isConfigured()) {
            return $this->getDefaultData();
        }

        return Cache::remember('facebook_account_overview', 3600, function () {
            try {
                $today = Carbon::today()->format('Y-m-d');
                $yesterday = Carbon::yesterday()->format('Y-m-d');
                $lastMonth = Carbon::today()->subMonth()->format('Y-m-d');

                // Get today's data
                $todayData = $this->getInsights($today, $today);
                
                // Get yesterday's data for comparison
                $yesterdayData = $this->getInsights($yesterday, $yesterday);
                
                // Get last 30 days data
                $monthData = $this->getInsights($lastMonth, $today);

                return [
                    'today' => $todayData,
                    'yesterday' => $yesterdayData,
                    'last_30_days' => $monthData,
                    'account_id' => $this->adAccountId,
                ];
            } catch (\Exception $e) {
                Log::error('Facebook API Error: ' . $e->getMessage());
                return $this->getDefaultData();
            }
        });
    }

    public function getMonthlyAdSpendData(int $months = 12): array
    {
        if (!$this->isConfigured()) {
            return $this->generateDummyMonthlyData($months);
        }

        return Cache::remember("facebook_monthly_data_{$months}", 3600, function () use ($months) {
            try {
                $results = [];
                for ($i = $months - 1; $i >= 0; $i--) {
                    $start = now()->startOfMonth()->subMonths($i)->format('Y-m-d');
                    $end = now()->startOfMonth()->subMonths($i)->endOfMonth()->format('Y-m-d');

                    $data = $this->getInsights($start, $end);
                    $results[] = [
                        'month' => now()->startOfMonth()->subMonths($i)->format('Y-m'),
                        'spend' => $data['spend'],
                        'clicks' => $data['clicks'],
                        'impressions' => $data['impressions'],
                        'roas' => $data['roas'],
                        'ctr' => $data['ctr'],
                        'cpc' => $data['cpc'],
                        'conversions' => $data['conversions'],
                    ];
                }

                return $results;
            } catch (\Exception $e) {
                Log::error('Facebook API Error: ' . $e->getMessage());
                return $this->generateDummyMonthlyData($months);
            }
        });
    }

    public function getCampaignPerformance(): array
    {
        if (!$this->isConfigured()) {
            return $this->generateDummyCampaignData();
        }

        return Cache::remember('facebook_campaign_performance', 1800, function () {
            try {
                $response = $this->fb->get(
                    "/{$this->adAccountId}/campaigns?fields=name,status,objective,daily_budget,lifetime_budget,created_time,start_time,stop_time&limit=50",
                    $this->accessToken
                );

                $campaigns = $response->getDecodedBody()['data'] ?? [];
                $results = [];

                foreach ($campaigns as $campaign) {
                    $insights = $this->getCampaignInsights($campaign['id']);
                    $results[] = [
                        'id' => $campaign['id'],
                        'name' => $campaign['name'],
                        'status' => $campaign['status'],
                        'objective' => $campaign['objective'] ?? 'Unknown',
                        'daily_budget' => $campaign['daily_budget'] ?? 0,
                        'lifetime_budget' => $campaign['lifetime_budget'] ?? 0,
                        'created_time' => $campaign['created_time'] ?? null,
                        'start_time' => $campaign['start_time'] ?? null,
                        'stop_time' => $campaign['stop_time'] ?? null,
                        'insights' => $insights,
                    ];
                }

                return $results;
            } catch (\Exception $e) {
                Log::error('Facebook API Error: ' . $e->getMessage());
                return $this->generateDummyCampaignData();
            }
        });
    }

    public function getAdSets(): array
    {
        if (!$this->isConfigured()) {
            return [];
        }

        return Cache::remember('facebook_adsets', 1800, function () {
            try {
                $response = $this->fb->get(
                    "/{$this->adAccountId}/adsets?fields=name,status,campaign_id,daily_budget,lifetime_budget,created_time,start_time,end_time,targeting&limit=50",
                    $this->accessToken
                );

                return $response->getDecodedBody()['data'] ?? [];
            } catch (\Exception $e) {
                Log::error('Facebook API Error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getTopPerformingAds(): array
    {
        if (!$this->isConfigured()) {
            return $this->generateDummyAdsData();
        }

        return Cache::remember('facebook_top_ads', 1800, function () {
            try {
                $last30Days = Carbon::today()->subDays(30)->format('Y-m-d');
                $today = Carbon::today()->format('Y-m-d');

                $response = $this->fb->get(
                    "/{$this->adAccountId}/ads?fields=name,status,campaign_id,adset_id,creative&time_range[since]={$last30Days}&time_range[until]={$today}&limit=20",
                    $this->accessToken
                );

                $ads = $response->getDecodedBody()['data'] ?? [];
                $results = [];

                foreach ($ads as $ad) {
                    $insights = $this->getAdInsights($ad['id'], $last30Days, $today);
                    $results[] = [
                        'id' => $ad['id'],
                        'name' => $ad['name'],
                        'status' => $ad['status'],
                        'campaign_id' => $ad['campaign_id'],
                        'adset_id' => $ad['adset_id'],
                        'insights' => $insights,
                    ];
                }

                // Sort by spend descending
                usort($results, function($a, $b) {
                    return $b['insights']['spend'] <=> $a['insights']['spend'];
                });

                return array_slice($results, 0, 10);
            } catch (\Exception $e) {
                Log::error('Facebook API Error: ' . $e->getMessage());
                return $this->generateDummyAdsData();
            }
        });
    }

    private function getInsights(string $since, string $until): array
    {
        $response = $this->fb->get(
            "/{$this->adAccountId}/insights?fields=spend,clicks,impressions,website_purchase_roas,ctr,cpc,conversions&time_range[since]={$since}&time_range[until]={$until}",
            $this->accessToken
        );

        $data = $response->getDecodedBody()['data'][0] ?? [];
        
        return [
            'spend' => isset($data['spend']) ? (float) $data['spend'] : 0,
            'clicks' => isset($data['clicks']) ? (int) $data['clicks'] : 0,
            'impressions' => isset($data['impressions']) ? (int) $data['impressions'] : 0,
            'roas' => isset($data['website_purchase_roas'][0]['value']) ? (float) $data['website_purchase_roas'][0]['value'] : 0,
            'ctr' => isset($data['ctr']) ? (float) $data['ctr'] : 0,
            'cpc' => isset($data['cpc']) ? (float) $data['cpc'] : 0,
            'conversions' => isset($data['conversions']) ? (int) $data['conversions'] : 0,
        ];
    }

    private function getCampaignInsights(string $campaignId): array
    {
        try {
            $last30Days = Carbon::today()->subDays(30)->format('Y-m-d');
            $today = Carbon::today()->format('Y-m-d');

            $response = $this->fb->get(
                "/{$campaignId}/insights?fields=spend,clicks,impressions,conversions,ctr,cpc&time_range[since]={$last30Days}&time_range[until]={$today}",
                $this->accessToken
            );

            $data = $response->getDecodedBody()['data'][0] ?? [];
            
            return [
                'spend' => isset($data['spend']) ? (float) $data['spend'] : 0,
                'clicks' => isset($data['clicks']) ? (int) $data['clicks'] : 0,
                'impressions' => isset($data['impressions']) ? (int) $data['impressions'] : 0,
                'conversions' => isset($data['conversions']) ? (int) $data['conversions'] : 0,
                'ctr' => isset($data['ctr']) ? (float) $data['ctr'] : 0,
                'cpc' => isset($data['cpc']) ? (float) $data['cpc'] : 0,
            ];
        } catch (\Exception $e) {
            return [
                'spend' => 0,
                'clicks' => 0,
                'impressions' => 0,
                'conversions' => 0,
                'ctr' => 0,
                'cpc' => 0,
            ];
        }
    }

    private function getAdInsights(string $adId, string $since, string $until): array
    {
        try {
            $response = $this->fb->get(
                "/{$adId}/insights?fields=spend,clicks,impressions,conversions,ctr,cpc&time_range[since]={$since}&time_range[until]={$until}",
                $this->accessToken
            );

            $data = $response->getDecodedBody()['data'][0] ?? [];
            
            return [
                'spend' => isset($data['spend']) ? (float) $data['spend'] : 0,
                'clicks' => isset($data['clicks']) ? (int) $data['clicks'] : 0,
                'impressions' => isset($data['impressions']) ? (int) $data['impressions'] : 0,
                'conversions' => isset($data['conversions']) ? (int) $data['conversions'] : 0,
                'ctr' => isset($data['ctr']) ? (float) $data['ctr'] : 0,
                'cpc' => isset($data['cpc']) ? (float) $data['cpc'] : 0,
            ];
        } catch (\Exception $e) {
            return [
                'spend' => 0,
                'clicks' => 0,
                'impressions' => 0,
                'conversions' => 0,
                'ctr' => 0,
                'cpc' => 0,
            ];
        }
    }

    private function getDefaultData(): array
    {
        return [
            'today' => ['spend' => 0, 'clicks' => 0, 'impressions' => 0, 'roas' => 0, 'ctr' => 0, 'cpc' => 0, 'conversions' => 0],
            'yesterday' => ['spend' => 0, 'clicks' => 0, 'impressions' => 0, 'roas' => 0, 'ctr' => 0, 'cpc' => 0, 'conversions' => 0],
            'last_30_days' => ['spend' => 0, 'clicks' => 0, 'impressions' => 0, 'roas' => 0, 'ctr' => 0, 'cpc' => 0, 'conversions' => 0],
            'account_id' => 'Not configured',
        ];
    }

    private function generateDummyMonthlyData(int $months): array
    {
        $results = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $results[] = [
                'month' => now()->startOfMonth()->subMonths($i)->format('Y-m'),
                'spend' => 0,
                'clicks' => 0,
                'impressions' => 0,
                'roas' => 0,
                'ctr' => 0,
                'cpc' => 0,
                'conversions' => 0,
            ];
        }
        return $results;
    }

    private function generateDummyCampaignData(): array
    {
        return [
            [
                'id' => 'demo_campaign_1',
                'name' => 'Demo Campaign 1',
                'status' => 'PAUSED',
                'objective' => 'CONVERSIONS',
                'daily_budget' => 0,
                'lifetime_budget' => 0,
                'created_time' => now()->subDays(30)->toISOString(),
                'start_time' => now()->subDays(30)->toISOString(),
                'stop_time' => null,
                'insights' => ['spend' => 0, 'clicks' => 0, 'impressions' => 0, 'conversions' => 0, 'ctr' => 0, 'cpc' => 0],
            ]
        ];
    }

    private function generateDummyAdsData(): array
    {
        return [
            [
                'id' => 'demo_ad_1',
                'name' => 'Demo Ad 1',
                'status' => 'PAUSED',
                'campaign_id' => 'demo_campaign_1',
                'adset_id' => 'demo_adset_1',
                'insights' => ['spend' => 0, 'clicks' => 0, 'impressions' => 0, 'conversions' => 0, 'ctr' => 0, 'cpc' => 0],
            ]
        ];
    }
}