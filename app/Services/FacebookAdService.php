<?php


namespace App\Services;

use Facebook\Facebook;

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

    public function getMonthlyAdSpendData(int $months = 12): array
    {
        $results = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $start = now()->startOfMonth()->subMonths($i)->format('Y-m-d');
            $end = now()->startOfMonth()->subMonths($i)->endOfMonth()->format('Y-m-d');

            // Fetch spend, clicks, impressions, and ROAS
            $response = $this->fb->get(
                "/{$this->adAccountId}/insights?fields=spend,clicks,impressions,website_purchase_roas&time_range[since]={$start}&time_range[until]={$end}",
                $this->accessToken
            );

            $data = $response->getDecodedBody();
            $results[] = [
                'spend' => isset($data['data'][0]['spend']) ? (float) $data['data'][0]['spend'] : 0,
                'clicks' => isset($data['data'][0]['clicks']) ? (int) $data['data'][0]['clicks'] : 0,
                'roas' => isset($data['data'][0]['website_purchase_roas'][0]['value']) ? (float) $data['data'][0]['website_purchase_roas'][0]['value'] : 0,
            ];
        }

        return $results;
    }
}