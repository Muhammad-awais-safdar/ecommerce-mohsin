<?php

namespace App\Filament\Widgets;

use App\Models\Ad;
use App\Services\AdService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }

    protected function getStats(): array
    {
        $adService = app(AdService::class);
        $analytics = $adService->getAnalyticsSummary();

        return [
            Stat::make('Total Ads', $analytics['total_ads'])
                ->description('All advertisements')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('primary'),

            Stat::make('Active Ads', $analytics['active_ads'])
                ->description('Currently running')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Views', number_format($analytics['total_views']))
                ->description('All-time impressions')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Total Clicks', number_format($analytics['total_clicks']))
                ->description('All-time clicks')
                ->descriptionIcon('heroicon-m-cursor-arrow-ripple')
                ->color('warning'),

            Stat::make('Average CTR', $analytics['average_ctr'] . '%')
                ->description('Click-through rate')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($analytics['average_ctr'] > 5 ? 'success' : ($analytics['average_ctr'] > 2 ? 'warning' : 'danger')),

            Stat::make('Expired Ads', $analytics['expired_ads'])
                ->description('Need attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}