<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Awais access';
    public static function getNavigationBadge(): ?string
    {
        return (string) User::count();
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->minLength(8)
                    ->dehydrated(fn($state) => ! empty($state) ? Hash::make($state) : null)
                    ->confirmed(),

                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->default(null), // Default as null

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                Checkbox::make('is_verified')
                    ->label('Verified')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('email_verified_at')->dateTime(),
                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable(),
                TextColumn::make('last_login_at')
                    ->label('Last Login At')
                    ->getStateUsing(fn($record) => $record->last_seen_at)
                    ->dateTime(),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        if (!$record->last_seen_at) {
                            return 'Offline';
                        }

                        $diffInMinutes = Carbon::now()->diffInMinutes($record->last_seen_at);

                        if ($diffInMinutes < 5) {
                            return '🟢 Online';
                        } else {
                            return '🔴 Offline (Last seen ' . $diffInMinutes . ' min ago)';
                        }
                    }),
                TextColumn::make('created_at')->sortable()->since(),
                TextColumn::make('updated_at')->sortable()->since(),
            ])->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
