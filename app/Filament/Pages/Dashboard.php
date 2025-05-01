<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\EarningsChart;
use App\Filament\Widgets\FacebookAdSpendChart;
use App\Filament\Widgets\FacebookLiveAdSpendChart;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            EarningsChart::class,
            // FacebookAdSpendChart::class,
            // FacebookLiveAdSpendChart::class,
        ];
    }
}