<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefundRequestResource\Pages;
use App\Filament\Resources\RefundRequestResource\Pages\CreateRefundRequest;
use App\Filament\Resources\RefundRequestResource\Pages\EditRefundRequest;
use App\Filament\Resources\RefundRequestResource\Pages\ListRefundRequests;
use App\Filament\Resources\RefundRequestResource\RelationManagers;
use App\Models\RefundRequest;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefundRequestResource extends Resource
{
    protected static ?string $model = RefundRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Refund Requests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->disabled(),
                TextInput::make('customer_name')->disabled(),
                TextInput::make('customer_email')->disabled(),
                TextInput::make('customer_phone')->disabled(),
                Textarea::make('reason')->disabled(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'denied' => 'Denied',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('order.id')->label('Order #')->sortable(),
                TextColumn::make('customer_name')->sortable(),
                TextColumn::make('customer_email'),
                BadgeColumn::make('status')
    ->formatStateUsing(function (string $state): string {
        return match ($state) {
            'pending' => 'Pending',
            'approved' => 'Approved',
            'denied' => 'Denied',
            default => ucfirst($state),
        };
    })
    ->colors([
        'warning' => 'pending',
        'success' => 'approved',
        'danger' => 'denied',
    ]),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'denied' => 'Denied',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRefundRequests::route('/'),
            'edit' => Pages\EditRefundRequest::route('/{record}/edit'),
        ];
    }
}