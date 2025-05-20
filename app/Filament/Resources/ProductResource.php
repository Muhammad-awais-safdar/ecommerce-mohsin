<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            Textarea::make('description'),
            TextInput::make('price')->required()->numeric(),
            TextInput::make('discount_percentage')
                ->label('Discount (%)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->nullable(),
            FileUpload::make('images')
                ->label('Product Images')
                ->image()
                ->multiple()
                ->reorderable()
                ->directory('products')
                ->imagePreviewHeight('200')
                ->maxFiles(5),
        ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('discount_percentage')->label('Discount'),
                ImageColumn::make('images.0')->label('Main Image')->width(100)->height(100),
                TextColumn::make('price')->label('Price'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ...(
                    $user && $user->email === 'awais@gmail.com'
                    ? [
                        RestoreAction::make(),
                        ForceDeleteAction::make(),
                    ]
                    : []
                ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ...(
                        $user && $user->email === 'awais@gmail.com'
                        ? [
                            RestoreBulkAction::make(),
                            ForceDeleteBulkAction::make(),
                        ]
                        : []
                    ),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Only allow awais@gmail.com to see soft-deleted records
        if (Auth::user()?->email === 'awais@gmail.com') {
            return $query->withTrashed();
        }

        return $query->withoutGlobalScopes([
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
