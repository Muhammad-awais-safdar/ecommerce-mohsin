<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class EarningsChart extends ChartWidget
{
    protected static ?string $heading = 'Total Earnings';
    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        // return 'bar';
        return 'line';
    }

    protected function getOptions(): ?array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 500,
                    ],
                ],
            ],
        ];
    }


    protected function getData(): array
    {
        $earnings = Order::selectRaw('SUM(total_amount) as total, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(30) // last 30 days (you can increase/decrease this)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Earnings',
                    'data' => $earnings->pluck('total')->toArray(),
                    'backgroundColor' => 'rgb(171 ,142 ,102 , 1)',
                    'borderColor' => 'rgb(171 ,142 ,102 , 0.5',
                    'fill' => true,
                    'tension' => 0.3, // smooth curve
                ],
            ],
            'labels' => $earnings->pluck('date')->toArray(),
        ];
    }
}
