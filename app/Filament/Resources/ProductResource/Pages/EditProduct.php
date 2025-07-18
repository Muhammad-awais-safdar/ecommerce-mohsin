<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        $data = $this->form->getState();

        $this->record->details()->updateOrCreate([], [
            'short_description'    => $data['description'] ?? null,
            'gender'               => $data['details']['gender'] ?? null,
            'fragrance_type'       => $data['details']['fragrance_type'] ?? null,
            'concentration'        => $data['details']['concentration'] ?? null,
            'top_notes'            => $data['details']['top_notes'] ?? null,
            'middle_notes'         => $data['details']['middle_notes'] ?? null,
            'base_notes'           => $data['details']['base_notes'] ?? null,
            'volume_ml'            => $data['details']['volume_ml'] ?? null,
            'longevity_hours'      => $data['details']['longevity_hours'] ?? null,
            'country_of_origin'    => $data['details']['country_of_origin'] ?? null,
        ]);

        $this->record->stock()->updateOrCreate([], [
            'quantity' => $data['stock']['quantity'] ?? 0,
        ]);
    }
}
