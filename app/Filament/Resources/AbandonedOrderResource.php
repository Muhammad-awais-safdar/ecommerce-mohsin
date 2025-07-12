<?php

namespace App\Filament\Resources;

use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use App\Filament\Resources\AbandonedOrderResource\Pages\ListAbandonedOrders;
use App\Filament\Resources\AbandonedOrderResource\Pages\EditAbandonedOrder;
use App\Filament\Resources\AbandonedOrderResource\Pages\CreateAbandonedOrder;

class AbandonedOrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';
    protected static ?string $navigationLabel = 'Abandoned Orders';
    protected static ?string $pluralLabel = 'Abandoned Orders';
    protected static ?string $label = 'Abandoned Order';
    protected static ?string $navigationGroup = 'Orders'; // optional: groups in sidebar

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'pending')
            ->withTrashed();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('customer_name')->disabled(),
            TextInput::make('customer_phone')->disabled(),
            TextInput::make('shipping_address')->disabled(),
            TextInput::make('total_amount')->disabled(),
            Select::make('status')
                ->required()
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ])
                ->native(false),
            TextInput::make('tracking_number'),
            TextInput::make('tracking_service_provider')
                ->label('Tracking Company')
                ->placeholder('Enter tracking company name'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('rowNumber')->label('#')->state(fn($record, $rowLoop) => $rowLoop->iteration),
            TextColumn::make('customer_name'),
                TextColumn::make('customer_phone'),
                TextColumn::make('customer_email'),
                TextColumn::make('total_amount'),
                TextColumn::make('status'),
                TextColumn::make('tracking_status')->label('Tracking'),
                TextColumn::make('tracking_service_provider')->label('Tracking Company'),
                TextColumn::make('created_at')->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('Restore')
                    ->visible(fn($record) => Auth::user()?->email === 'awais@gmail.com' && $record->trashed())
                    ->action(fn($record) => $record->restore())
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation(),
                DeleteAction::make()
                    ->visible(fn($record) => Auth::user()?->email === 'awais@gmail.com'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('softDelete')
                        ->label('Delete Selected')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            if (Auth::user()?->email === 'awais@gmail.com') {
                                $records->each->delete();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbandonedOrders::route('/'),
            'create' => CreateAbandonedOrder::route('/create'),
            'edit' => EditAbandonedOrder::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['customer_name', 'customer_email'];
    }
}
