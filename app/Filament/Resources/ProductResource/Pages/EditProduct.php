<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
    
    protected function beforeSave(): void
    {
        $data = $this->form->getState();
        
        // Validate stock quantity
        if (isset($data['stock'])) {
            $quantity = (int)($data['stock']['quantity'] ?? 0);
            
            if ($quantity < 0) {
                Notification::make()
                    ->title('Invalid Stock Quantity')
                    ->body('Stock quantity cannot be negative.')
                    ->danger()
                    ->send();
                $this->halt();
            }
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load the product with its relationships
        $product = $this->record->load(['details', 'stock']);
        
        // Add details data to form data with null coalescence for safety
        if ($product->details) {
            $data['details'] = [
                'gender' => $product->details->gender,
                'fragrance_type' => $product->details->fragrance_type,
                'concentration' => $product->details->concentration,
                'top_notes' => $product->details->top_notes,
                'middle_notes' => $product->details->middle_notes,
                'base_notes' => $product->details->base_notes,
                'volume_ml' => $product->details->volume_ml,
                'longevity_hours' => $product->details->longevity_hours,
                'country_of_origin' => $product->details->country_of_origin,
                'short_description' => $product->details->short_description,
                'long_description' => $product->details->long_description,
            ];
        } else {
            // Initialize empty details if none exist
            $data['details'] = [
                'gender' => null,
                'fragrance_type' => null,
                'concentration' => null,
                'top_notes' => null,
                'middle_notes' => null,
                'base_notes' => null,
                'volume_ml' => null,
                'longevity_hours' => null,
                'country_of_origin' => null,
                'short_description' => null,
                'long_description' => null,
            ];
        }

        // Add stock data to form data
        if ($product->stock) {
            $data['stock'] = [
                'quantity' => $product->stock->quantity,
            ];
        } else {
            // Initialize default stock values if none exist
            $data['stock'] = [
                'quantity' => 0,
            ];
        }

        return $data;
    }
    protected function afterSave(): void
    {
        $data = $this->form->getState();

        // Update or create product details with comprehensive data handling
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

        // Update or create stock information
        $this->record->stock()->updateOrCreate([], [
            'quantity' => (int)($data['stock']['quantity'] ?? 0),
        ]);
        
        // Send notification for low stock (using default thresholds)
        $quantity = (int)($data['stock']['quantity'] ?? 0);
        
        if ($quantity <= 5) {
            Notification::make()
                ->title('Stock Alert: Very Low Stock')
                ->body("Product '{$this->record->name}' is very low in stock. Quantity: {$quantity}")
                ->danger()
                ->send();
        } elseif ($quantity <= 10) {
            Notification::make()
                ->title('Low Stock Warning')
                ->body("Product '{$this->record->name}' is running low. Quantity: {$quantity}")
                ->warning()
                ->send();
        }
    }
}
