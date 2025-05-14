<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LoginActivity;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LoginActivityResource\Pages;
use App\Filament\Resources\LoginActivityResource\RelationManagers;
use App\Filament\Resources\LoginActivityResource\Pages\EditLoginActivity;
use App\Filament\Resources\LoginActivityResource\Pages\CreateLoginActivity;
use App\Filament\Resources\LoginActivityResource\Pages\ListLoginActivities;
use Illuminate\Support\Facades\Auth;

class LoginActivityResource extends Resource
{
    protected static ?string $model = LoginActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return (string) \App\Models\LoginActivity::whereDate('created_at', now())->count();
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === 'awais' && $user->email === 'awais@gmail.com';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->searchable()->sortable(),
                TextColumn::make('ip_address')->label('IP')->copyable()->searchable(),
                TextColumn::make('location')->label('Location')->searchable(),
                TextColumn::make('isp')->label('ISP'),
                TextColumn::make('device_type')->label('Device'),
                TextColumn::make('platform')->label('Platform'),
                TextColumn::make('browser')->label('Browser'),
                TextColumn::make('created_at')->label('Login Time')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLoginActivities::route('/'),
            // 'create' => Pages\CreateLoginActivity::route('/create'),
            // 'edit' => Pages\EditLoginActivity::route('/{record}/edit'),
        ];
    }
}
