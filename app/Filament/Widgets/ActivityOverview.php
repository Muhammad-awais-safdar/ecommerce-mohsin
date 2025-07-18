<?php

namespace App\Filament\Widgets;

use App\Services\ActivityLogService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActivityOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $activityService = app(ActivityLogService::class);
        $stats = $activityService->getTodayStats();

        return [
            Stat::make('Total Activities Today', $stats['total_activities'])
                ->description('All system activities')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('User Activities', $stats['user_activities'])
                ->description('Activities by logged-in users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('System Activities', $stats['system_activities'])
                ->description('Automated system activities')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('warning'),

            Stat::make('Logins Today', $stats['logins'])
                ->description('User login sessions')
                ->descriptionIcon('heroicon-m-arrow-right-on-rectangle')
                ->color('info'),

            Stat::make('Active Users', $stats['unique_users'])
                ->description('Unique users active today')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}