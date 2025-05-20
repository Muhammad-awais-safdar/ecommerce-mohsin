<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Services\FacebookAdService;

class FacebookAdSpendChart extends ChartWidget
{
    protected static ?string $heading = 'Facebook Ad Spend, Clicks, and ROAS';

    protected function getData(): array
    {
        $facebookService = new FacebookAdService();
        $adData = $facebookService->getMonthlyAdSpendData();

        $spendData = array_column($adData, 'spend');
        $clicksData = array_column($adData, 'clicks');
        $roasData = array_column($adData, 'roas');

        return [
            'datasets' => [
                [
                    'label' => 'Ad Spend',
                    'data' => $spendData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                ],
                [
                    'label' => 'Clicks',
                    'data' => $clicksData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
                [
                    'label' => 'ROAS',
                    'data' => $roasData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                ],
            ],
            'labels' => collect(range(0, 11))->map(fn ($i) =>
                now()->subMonths(11 - $i)->format('M Y')
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}