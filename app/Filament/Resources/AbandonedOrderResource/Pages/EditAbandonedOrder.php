<?php

namespace App\Filament\Resources\AbandonedOrderResource\Pages;

use App\Filament\Resources\AbandonedOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbandonedOrder extends EditRecord
{
    protected static string $resource = AbandonedOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
