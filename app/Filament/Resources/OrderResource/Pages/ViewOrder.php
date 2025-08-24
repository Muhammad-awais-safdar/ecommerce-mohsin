<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\OrderItem;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View; // ✅ Make sure this is correct
use App\Filament\Resources\OrderResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    public function getFooter(): ?View
    {
        return view('filament.resources.orders.view', [
            'order' => $this->record,
            'orderItems' => $this->record->orderItems()->with('product')->get(),
        ]);
    }
}