<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TrackingScript;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Validation\Rules\ClosureValidationRule;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TrackingScriptResource\Pages;
use App\Filament\Resources\TrackingScriptResource\RelationManagers;
use App\Filament\Resources\TrackingScriptResource\Pages\EditTrackingScript;
use App\Filament\Resources\TrackingScriptResource\Pages\ListTrackingScripts;
use App\Filament\Resources\TrackingScriptResource\Pages\CreateTrackingScript;

class TrackingScriptResource extends Resource
{
    protected static ?string $model = TrackingScript::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                Textarea::make('script')
                    ->label('Script (JS or HTML)')
                    ->rows(10)
                    ->required()
                    ->maxLength(5000),
                Select::make('location')
                    ->options(['head' => 'In <head>', 'body_end' => 'Before </body>'])
                    ->required(),
                Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                BadgeColumn::make('location')->colors(['primary']),
                IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTrackingScripts::route('/'),
            'create' => Pages\CreateTrackingScript::route('/create'),
            'edit' => Pages\EditTrackingScript::route('/{record}/edit'),
        ];
    }
}
