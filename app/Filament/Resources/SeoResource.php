<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoResource\Pages;
use App\Filament\Resources\SeoResource\RelationManagers;
use App\Models\Seo;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeoResource extends Resource
{
    protected static ?string $model = Seo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('page')->label('Page Identifier')->required()->unique(ignoreRecord: true),
                TextInput::make('meta_title')->label('Meta Title')->maxLength(60),
                Textarea::make('meta_description')->label('Meta Description')->maxLength(160),
                TextInput::make('meta_keywords')->label('Meta Keywords'),

                TextInput::make('og_title')->label('OG Title'),

                FileUpload::make('og_image')
                    ->label('OG Image')
                    ->image()
                    ->directory('seo/og') // Stored in: storage/app/public/seo/og
                    ->visibility('public'),

                TextInput::make('canonical_url')->label('Canonical URL'),
                TextInput::make('robots')->label('Robots')->default('index, follow'),

                TextInput::make('twitter_title')->label('Twitter Title'),

                FileUpload::make('twitter_image')
                    ->label('Twitter Image')
                    ->image()
                    ->directory('seo/twitter')
                    ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page'),
                TextColumn::make('meta_title'),
                TextColumn::make('created_at')->date(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSeos::route('/'),
            'create' => Pages\CreateSeo::route('/create'),
            'edit' => Pages\EditSeo::route('/{record}/edit'),
        ];
    }
}