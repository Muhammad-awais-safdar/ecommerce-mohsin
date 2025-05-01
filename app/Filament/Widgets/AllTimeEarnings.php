<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;
use App\Models\Order;

class AllTimeEarnings extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $totalEarnings = Order::sum('total_amount');

        return [
            Card::make('All-Time Earnings', 'USD :' . number_format($totalEarnings, 2))
                ->description('Cumulative earnings from all orders')
                ->color('success'),
        ];
    }
}