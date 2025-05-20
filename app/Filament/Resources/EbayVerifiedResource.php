<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\EbayVerified;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EbayVerifiedResource\Pages;
use App\Filament\Resources\EbayVerifiedResource\Pages\ListEbayVerifieds;

class EbayVerifiedResource extends Resource
{
    protected static ?string $model = EbayVerified::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'eBay Verified Images';
    protected static ?string $pluralLabel = 'eBay Verified Images';

    public static function form(Form $form): Form
    {
        return $form->schema([
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
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        $isAwais = fn() => Auth::user()?->email === 'awais@gamail.com';

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
            ->filters([
                TrashedFilter::make()->visible($isAwais),
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

                RestoreAction::make()->visible($isAwais),
                ForceDeleteAction::make()->visible($isAwais),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEbayVerifieds::route('/'),
        ];
    }
}
