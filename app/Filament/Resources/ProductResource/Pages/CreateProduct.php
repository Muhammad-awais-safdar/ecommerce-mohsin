<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        // Create product details with comprehensive data handling
        $this->record->details()->updateOrCreate([], [
            'short_description'    => $data['details']['short_description'] ?? null,
            'long_description'     => $data['details']['long_description'] ?? null,
            'gender'               => $data['details']['gender'] ?? null,
            'fragrance_type'       => $data['details']['fragrance_type'] ?? null,
            'concentration'        => $data['details']['concentration'] ?? null,
            'top_notes'            => $data['details']['top_notes'] ?? null,
            'middle_notes'         => $data['details']['middle_notes'] ?? null,
            'base_notes'           => $data['details']['base_notes'] ?? null,
            'volume_ml'            => !empty($data['details']['volume_ml']) ? (int)$data['details']['volume_ml'] : null,
            'longevity_hours'      => !empty($data['details']['longevity_hours']) ? (int)$data['details']['longevity_hours'] : null,
            'country_of_origin'    => $data['details']['country_of_origin'] ?? null,
        ]);

        // Create stock information
        $this->record->stock()->updateOrCreate([], [
            'quantity' => (int)($data['stock']['quantity'] ?? 0),
        ]);

        // Clear product cache after creating new product
        app(\App\Services\ProductCacheService::class)->clearAllProductCache();
        
        // Send notification based on publication status
        $status = $this->record->publication_status;
        $message = match($status) {
            'published' => 'Product created and published successfully! It is now visible to customers.',
            'draft' => 'Product created as draft. You can publish it when ready.',
            'archived' => 'Product created and archived.',
            default => 'Product created successfully.'
        };
        
        \Filament\Notifications\Notification::make()
            ->title($message)
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        // Redirect to edit page after creation for immediate review
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
