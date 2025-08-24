<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Order;

class EarningsChart extends ApexChartWidget
{
    protected static ?string $heading = 'Total Earnings';
    protected static ?string $chartId = 'earningsChart';
    protected int | string | array $columnSpan = 'full';

    protected function getOptions(): array
    {
        $earnings = Order::selectRaw('SUM(total_amount) as total, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(30)
            ->get();

        return [
            'chart' => [
                'type' => 'area', // You can change to 'line' or 'bar'
                'height' => 350,
                'toolbar' => ['show' => true],
            ],
            'series' => [
                [
                    'name' => 'Earnings',
                    'data' => $earnings->pluck('total')->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => $earnings->pluck('date')->toArray(),
                'labels' => ['rotate' => 45],
            ],
            'colors' => ['#ab8e66'],
            'stroke' => ['curve' => 'smooth'],
            'dataLabels' => ['enabled' => true],
            'fill' => ['type' => 'gradient', 'gradient' => ['shadeIntensity' => 1, 'opacityFrom' => 0.8, 'opacityTo' => 0.4]],
        ];
    }
}
