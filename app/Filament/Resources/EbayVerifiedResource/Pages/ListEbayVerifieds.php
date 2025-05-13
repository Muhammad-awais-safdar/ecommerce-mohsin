<?php

namespace App\Filament\Resources\EbayVerifiedResource\Pages;

use App\Filament\Resources\EbayVerifiedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEbayVerifieds extends ListRecords
{
    protected static string $resource = EbayVerifiedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
