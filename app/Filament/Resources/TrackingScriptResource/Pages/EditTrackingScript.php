<?php

namespace App\Filament\Resources\TrackingScriptResource\Pages;

use App\Filament\Resources\TrackingScriptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrackingScript extends EditRecord
{
    protected static string $resource = TrackingScriptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
