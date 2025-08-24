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
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;

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
                    
                Select::make('publication_status')
                    ->label('Publication Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required()
                    ->helperText('Set the publication status of this product'),
            ]),

            // Textarea::make('description')->label('Short Description'),

            Grid::make(3)->schema([
                Select::make('details.gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'unisex' => 'Unisex',
                    ])
                    ->label('Gender')
                    ->placeholder('Select target gender')
                    ->helperText('Target audience for this perfume'),

                Select::make('details.fragrance_type')
                    ->label('Fragrance Type')
                    ->options([
                        'floral' => 'Floral',
                        'woody' => 'Woody',
                        'citrus' => 'Citrus',
                        'oriental' => 'Oriental',
                        'fresh' => 'Fresh',
                        'spicy' => 'Spicy',
                        'fruity' => 'Fruity',
                        'aquatic' => 'Aquatic',
                    ])
                    ->searchable()
                    ->placeholder('Select fragrance family'),
                    
                Select::make('details.concentration')
                    ->label('Concentration')
                    ->options([
                        'parfum' => 'Parfum (20-40%)',
                        'edp' => 'Eau de Parfum (15-20%)',
                        'edt' => 'Eau de Toilette (5-15%)',
                        'edc' => 'Eau de Cologne (2-4%)',
                        'edl' => 'Eau de Luxe (5-10%)',
                    ])
                    ->placeholder('Select concentration level')
                    ->helperText('Oil concentration in the fragrance'),
            ]),

            Grid::make(3)->schema([
                TextInput::make('details.top_notes')
                    ->label('Top Notes')
                    ->placeholder('e.g., Bergamot, Lemon, Apple')
                    ->helperText('Initial scents (0-15 minutes)')
                    ->maxLength(255),
                    
                TextInput::make('details.middle_notes')
                    ->label('Middle/Heart Notes')
                    ->placeholder('e.g., Rose, Jasmine, Lavender')
                    ->helperText('Core scents (15 minutes - 3 hours)')
                    ->maxLength(255),
                    
                TextInput::make('details.base_notes')
                    ->label('Base Notes')
                    ->placeholder('e.g., Vanilla, Musk, Sandalwood')
                    ->helperText('Lasting scents (3+ hours)')
                    ->maxLength(255),
            ]),

            Grid::make(3)->schema([
                TextInput::make('details.volume_ml')
                    ->numeric()
                    ->label('Volume (ml)')
                    ->minValue(1)
                    ->maxValue(1000)
                    ->suffix('ml')
                    ->helperText('Bottle size in milliliters'),
                    
                TextInput::make('details.longevity_hours')
                    ->numeric()
                    ->label('Longevity (hours)')
                    ->minValue(1)
                    ->maxValue(24)
                    ->suffix('hrs')
                    ->helperText('Expected duration on skin'),
                    
                TextInput::make('details.country_of_origin')
                    ->label('Country of Origin')
                    ->placeholder('e.g., France, Italy, UAE')
                    ->helperText('Where the perfume is manufactured'),
            ]),
            Grid::make(1)->schema([
                RichEditor::make('details.short_description')
                    ->label('Short Description')
                    ->placeholder('Brief product summary for listings...')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                    ])
                    ->helperText('Brief description for product cards (recommended: 100-150 characters)'),
            ]),
            
            Grid::make(1)->schema([
                RichEditor::make('details.long_description')
                    ->label('Detailed Description')
                    ->placeholder('Comprehensive product description with features, benefits, and usage instructions...')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                    ])
                    ->helperText('Detailed description for product detail page'),
            ]),

            TextInput::make('stock.quantity')
                ->label('Stock Quantity')
                ->numeric()
                ->minValue(0)
                ->required()
                ->helperText('Total quantity available in stock'),
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
            
            BadgeColumn::make('publication_status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => ucfirst($state))
                ->colors([
                    'secondary' => 'draft',
                    'success' => 'published',
                    'warning' => 'archived',
                ])
                ->icons([
                    'heroicon-o-pencil' => 'draft',
                    'heroicon-o-eye' => 'published',
                    'heroicon-o-archive-box' => 'archived',
                ]),
                
            TextColumn::make('published_at')
                ->label('Published')
                ->dateTime('M j, Y g:i A')
                ->sortable()
                ->toggleable()
                ->placeholder('Not published'),
                
            TextColumn::make('publisher.name')
                ->label('Published By')
                ->toggleable()
                ->placeholder('—'),

        ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('publication_status')
                    ->label('Publication Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->visible(fn (Product $record): bool => $record->isDraft())
                    ->requiresConfirmation()
                    ->modalHeading('Publish Product')
                    ->modalDescription('Are you sure you want to publish this product? It will be visible to customers.')
                    ->action(function (Product $record): void {
                        $record->publish();
                        Notification::make()
                            ->title('Product published successfully')
                            ->success()
                            ->send();
                    }),
                    
                Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-eye-slash')
                    ->color('warning')
                    ->visible(fn (Product $record): bool => $record->isPublished())
                    ->requiresConfirmation()
                    ->modalHeading('Unpublish Product')
                    ->modalDescription('Are you sure you want to unpublish this product? It will no longer be visible to customers.')
                    ->action(function (Product $record): void {
                        $record->unpublish();
                        Notification::make()
                            ->title('Product unpublished successfully')
                            ->success()
                            ->send();
                    }),
                    
                Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('gray')
                    ->visible(fn (Product $record): bool => !$record->isArchived())
                    ->requiresConfirmation()
                    ->modalHeading('Archive Product')
                    ->modalDescription('Are you sure you want to archive this product? It will be moved to archived status.')
                    ->action(function (Product $record): void {
                        $record->archive();
                        Notification::make()
                            ->title('Product archived successfully')
                            ->success()
                            ->send();
                    }),
                    
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
                    \Filament\Tables\Actions\BulkAction::make('bulk_publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Publish Products')
                        ->modalDescription('Are you sure you want to publish the selected products?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->isDraft()) {
                                    $record->publish();
                                    $count++;
                                }
                            }
                            Notification::make()
                                ->title("{$count} products published successfully")
                                ->success()
                                ->send();
                        }),
                        
                    \Filament\Tables\Actions\BulkAction::make('bulk_unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Unpublish Products')
                        ->modalDescription('Are you sure you want to unpublish the selected products?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->isPublished()) {
                                    $record->unpublish();
                                    $count++;
                                }
                            }
                            Notification::make()
                                ->title("{$count} products unpublished successfully")
                                ->success()
                                ->send();
                        }),
                        
                    \Filament\Tables\Actions\BulkAction::make('bulk_draft_all')
                        ->label('Set ALL Products to Draft')
                        ->icon('heroicon-o-pencil-square')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->modalHeading('Set All Products to Draft')
                        ->modalDescription('Are you sure you want to set ALL products in the database to draft status? This will affect all products, not just the selected ones.')
                        ->action(function (): void {
                            $count = Product::whereNot('publication_status', 'draft')->count();
                            Product::whereNot('publication_status', 'draft')->update([
                                'publication_status' => 'draft',
                                'published_at' => null,
                                'published_by' => null,
                            ]);
                            
                            // Clear product cache
                            app(\App\Services\ProductCacheService::class)->clearAllProductCache();
                            
                            Notification::make()
                                ->title("All {$count} products set to draft successfully")
                                ->success()
                                ->send();
                        }),
                        
                    \Filament\Tables\Actions\BulkAction::make('bulk_publish_all')
                        ->label('Publish ALL Products')
                        ->icon('heroicon-o-globe-alt')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Publish All Products')
                        ->modalDescription('Are you sure you want to publish ALL products in the database? This will make all products visible to customers.')
                        ->action(function (): void {
                            $count = Product::whereNot('publication_status', 'published')->count();
                            Product::whereNot('publication_status', 'published')->update([
                                'publication_status' => 'published',
                                'published_at' => now(),
                                'published_by' => Auth::id(),
                            ]);
                            
                            // Clear product cache
                            app(\App\Services\ProductCacheService::class)->clearAllProductCache();
                            
                            Notification::make()
                                ->title("All {$count} products published successfully")
                                ->success()
                                ->send();
                        }),
                        
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
