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
        return 'line';
    }

    protected function getOptions(): ?array
    {
        return [
            'scales' => [
                'y' => [
                    'min' => 20,
                    'max' => 200,
                    'ticks' => [
                        'stepSize' => 20,
                    ],
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $earnings = Order::selectRaw('SUM(total_amount) as total, strftime("%b %Y", created_at) as month')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at) ASC')
            ->take(12)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Earnings',
                    'data' => $earnings->pluck('total')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
            ],
            'labels' => $earnings->pluck('month')->toArray(),
        ];
    }
}