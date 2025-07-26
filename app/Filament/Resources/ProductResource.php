<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\CheckboxColumn;
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
use Filament\Forms\Components\RichEditor;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('name')->required(),
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
                TextInput::make('sku')
                    ->default(fn () => 'PROD-' . strtoupper(Str::random(6)))
                    ->disabled(), 
            ]),

            Textarea::make('description')->label('Short Description'),

            Grid::make(3)->schema([
                Select::make('details.gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'unisex' => 'Unisex',
                    ])
                    ->label('Gender'),

                TextInput::make('details.fragrance_type')->label('Fragrance Type'),
                TextInput::make('details.concentration')->label('Concentration (EDP, EDT, etc)'),
            ]),

            Grid::make(3)->schema([
                TextInput::make('details.top_notes')->label('Top Notes'),
                TextInput::make('details.middle_notes')->label('Middle Notes'),
                TextInput::make('details.base_notes')->label('Base Notes'),
            ]),

            Grid::make(3)->schema([
                TextInput::make('details.volume_ml')->numeric()->label('Volume (ml)'),
                TextInput::make('details.longevity_hours')->numeric()->label('Longevity (hrs)'),
                TextInput::make('details.country_of_origin')->label('Country of Origin'),
            ]),
            Grid::make(2)->schema([
                RichEditor::make('details.short_description')->label('Short Description'),
                RichEditor::make('details.long_description')->label('Short Description'),
            ]),

            TextInput::make('stock.quantity')->label('Stock Quantity')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->columns([
            TextColumn::make('sku')
                ->label('SKU'),
            TextColumn::make('name')
                ->label('Name'),

            TextColumn::make('discount_percentage')
                ->label('Discount')
                ->formatStateUsing(fn($state) => $state . '%')
                ->color(fn($state) => $state > 50 ? 'danger' : 'success') // red if >50%, green otherwise
                ->badge() // add badge style
                ->tooltip(fn($state) => $state > 50 ? 'High discount!' : 'Normal discount'),

            ImageColumn::make('images.0')
                ->label('Main Image')
                ->width(100)
                ->height(100),

            TextColumn::make('price')
                ->label('Price')
                ->formatStateUsing(fn($state) => '$' . number_format($state, 2)),

            TextColumn::make('stock.quantity')
                ->label('Stock')
                ->formatStateUsing(function ($state) {
                    return $state == 0 ? 'Out of stock' : $state;
                })
                ->color(fn($state) => $state == 'Out of stock' ? 'danger' : 'success') // red if out of stock, green otherwise
                ->badge() // add badge style
                ->icon(fn($state) => $state !== 'Out of stock' ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->tooltip(fn($state) => $state == 'Out of stock' ? 'No items left' : 'In stock'),

            CheckboxColumn::make('is_deal'),



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
