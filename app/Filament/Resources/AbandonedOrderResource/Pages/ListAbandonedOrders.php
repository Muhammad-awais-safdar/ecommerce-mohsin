<?php

namespace App\Filament\Resources\AbandonedOrderResource\Pages;

use App\Filament\Resources\AbandonedOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbandonedOrders extends ListRecords
{
    protected static string $resource = AbandonedOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
