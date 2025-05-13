<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EbayVerifiedResource\Pages;
use App\Models\EbayVerified;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EbayVerifiedResource extends Resource
{
    protected static ?string $model = EbayVerified::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'eBay Verified Images';
    protected static ?string $pluralLabel = 'eBay Verified Images';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('imagePath')
                    ->label('Image')
                    ->required()
                    ->disk('public')
                    ->directory('ebay_verifieds')
                    ->preserveFilenames()
                    ->enableOpen()
                    ->enableDownload()
                    ->image()
                    ->imageEditor(),

                Forms\Components\TextInput::make('imageName')
                    ->label('Image Name')
                    ->required()
                    ->maxLength(255),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagePath')
                    ->label('Image')
                    ->disk('public')
                    ->defaultImageUrl(url('images/default-placeholder.png')),

                Tables\Columns\TextColumn::make('imageName')
                    ->label('Image Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Add New eBay Image')
                    ->form([
                        Forms\Components\FileUpload::make('imagePath')
                            ->label('Image')
                            ->required()
                            ->disk('public')
                            ->directory('ebay_verifieds')
                            ->preserveFilenames()
                            ->enableOpen()
                            ->enableDownload()
                            ->image()
                            ->imageEditor(),

                        Forms\Components\TextInput::make('imageName')
                            ->label('Image Name')
                            ->required()
                            ->maxLength(255),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit eBay Image')
                    ->form([
                        Forms\Components\FileUpload::make('imagePath')
                            ->label('Image')
                            ->required()
                            ->disk('public')
                            ->directory('ebay_verifieds')
                            ->preserveFilenames()
                            ->enableOpen()
                            ->enableDownload()
                            ->image()
                            ->imageEditor(),

                        Forms\Components\TextInput::make('imageName')
                            ->label('Image Name')
                            ->required()
                            ->maxLength(255),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEbayVerifieds::route('/'),
            
        ];
    }
}
