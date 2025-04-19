<?php

namespace App\Filament\Resources\OrderItemsRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('product.name')->label('Product'),
            TextColumn::make('quantity'),
            TextColumn::make('price')->money('USD', true),
        ]);
    }
}