<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AllTimeEarnings;
use Filament\Pages\Page;
use App\Filament\Widgets\EarningsChart;
use App\Filament\Widgets\ActivityOverview;
use App\Filament\Widgets\ActivityChart;
use App\Filament\Widgets\RecentActivities;
use App\Filament\Widgets\FacebookAdSpendChart;
use App\Filament\Widgets\FacebookLiveAdSpendChart;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            AllTimeEarnings::class,
            ActivityOverview::class,
            EarningsChart::class,
            ActivityChart::class,
            RecentActivities::class,
        ];
    }
}