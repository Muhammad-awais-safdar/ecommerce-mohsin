<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Contact;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\ContactResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContactResource\Pages\EditContact;
use App\Filament\Resources\ContactResource\Pages\ListContacts;
use App\Filament\Resources\ContactResource\Pages\CreateContact;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-m-chat-bubble-left-right';

    protected static ?string $slug = 'contacts';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name'),
                TextInput::make('email')->label('Email')->email(),
                TextInput::make('phone')->label('Phone'),
                TextInput::make('company')->label('Company'),
                Textarea::make('message')->label('Message'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isAwais = fn() => Auth::user()?->email === 'awais@gamail.com';

        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('company'),
                TextColumn::make('message')->limit(50),
                TextColumn::make('created_at')->since()->label('Date Submitted'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make()->visible($isAwais),
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make()->label('View Details')->modalHeading('Contact Details')->modalWidth('lg'),
                RestoreAction::make()->visible($isAwais),
                ForceDeleteAction::make()->visible($isAwais),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make()->visible($isAwais),
                    ForceDeleteBulkAction::make()->visible($isAwais),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
