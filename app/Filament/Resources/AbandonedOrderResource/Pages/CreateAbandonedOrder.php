<?php

namespace App\Filament\Resources\AbandonedOrderResource\Pages;

use App\Filament\Resources\AbandonedOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAbandonedOrder extends CreateRecord
{
    protected static string $resource = AbandonedOrderResource::class;
}
