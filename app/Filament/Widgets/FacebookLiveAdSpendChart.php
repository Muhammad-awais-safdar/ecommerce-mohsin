<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Services\FacebookAdService;

class FacebookLiveAdSpendChart extends ChartWidget
{
    protected static ?string $heading = 'Facebook Ad Spend (Live from Meta)';

    protected function getData(): array
    {
        $facebookService = new FacebookAdService();
        $spendData = $facebookService->getMonthlyAdSpendData();

        return [
            'datasets' => [
                [
                    'label' => 'Facebook Ad Spend',
                    'data' => $spendData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
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