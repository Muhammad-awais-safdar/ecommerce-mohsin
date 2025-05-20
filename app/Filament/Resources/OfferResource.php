<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Offer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Events\OfferStatusUpdated;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use App\Filament\Resources\OfferResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OfferResource\Pages\EditOffer;
use App\Filament\Resources\OfferResource\Pages\ListOffers;
use App\Filament\Resources\OfferResource\Pages\CreateOffer;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_id')
                    ->numeric()
                    ->required(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->email(),

                TextInput::make('phone'),

                TextInput::make('quantity')
                    ->numeric(),

                TextInput::make('offer_price')
                    ->numeric()
                    ->required(),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'declined' => 'Declined',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')->label('Product Name'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('phone'),
                TextColumn::make('quantity'),
                TextColumn::make('offer_price')->money('USD'),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'accepted',
                        'danger' => 'declined',
                    ]),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Action::make('Accept')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->status = 'accepted';
                        $record->save();
                        OfferStatusUpdated::dispatch($record);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check'),

                Action::make('Decline')
                    ->color('danger')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->status = 'declined';
                        $record->save();
                        OfferStatusUpdated::dispatch($record);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-x-mark'),

                Tables\Actions\EditAction::make(),

                Action::make('Restore')
                    ->visible(fn($record) => Auth::user()?->email === 'awais@gmail.com' && $record->trashed())
                    ->action(fn($record) => $record->restore())
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation(),

                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
