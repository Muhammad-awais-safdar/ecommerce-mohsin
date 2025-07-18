<?php

namespace App\Filament\Widgets;

use App\Services\ActivityLogService;
use Filament\Widgets\ChartWidget;

class ActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Hourly Activity Today';

    protected function getData(): array
    {
        $activityService = app(ActivityLogService::class);
        $hourlyData = $activityService->getHourlyActivity();

        return [
            'datasets' => [
                [
                    'label' => 'Activities',
                    'data' => array_values($hourlyData),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => array_map(fn($hour) => sprintf('%02d:00', $hour), array_keys($hourlyData)),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}