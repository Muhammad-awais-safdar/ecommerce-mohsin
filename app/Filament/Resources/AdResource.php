<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Models\Ad;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\Auth;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Awais access';
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ad Content')
                    ->description('Basic ad information and content')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),

                            Textarea::make('description')
                                ->label('Description')
                                ->placeholder('Brief description of your ad (optional)')
                                ->maxLength(500)
                                ->rows(3)
                                ->columnSpan(2),

                            Select::make('product_id')
                                ->label('Linked Product (Optional)')
                                ->placeholder('Select a product to link with this ad')
                                ->relationship('product', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('price')
                                        ->required()
                                        ->numeric()
                                        ->prefix('£'),
                                ])
                                ->helperText('If selected and no custom image is uploaded, the product image will be used.')
                                ->columnSpan(1),

                            Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->helperText('Only active ads will be displayed on the frontend')
                                ->columnSpan(1),
                        ]),
                    ]),

                Section::make('Ad Image')
                    ->description('Upload a custom image for your ad')
                    ->schema([
                        FileUpload::make('custom_image')
                            ->label('Ad Image')
                            ->image()
                            ->directory('ads')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->helperText('Upload an image for your ad. This will be displayed in the modal popup.')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),

                        Placeholder::make('image_preview')
                            ->label('Current Image Preview')
                            ->content(function (?Ad $record) {
                                if (!$record) {
                                    return 'Image preview will appear here after saving the ad';
                                }

                                $imageUrl = $record->image_url;
                                if ($imageUrl) {
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="text-center">
                                            <img src="' . $imageUrl . '" alt="Ad Image" style="max-width: 300px; max-height: 200px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                            <p class="mt-2 text-sm text-gray-600">Current ad image</p>
                                        </div>'
                                    );
                                }

                                return 'No image available - please upload an image above';
                            })
                            ->columnSpanFull(),
                    ]),

                Section::make('Call to Action')
                    ->description('Button configuration')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('button_text')
                                ->required()
                                ->maxLength(50)
                                ->placeholder('e.g., Shop Now, Buy Now, Learn More')
                                ->columnSpan(1),

                            TextInput::make('button_link')
                                ->required()
                                ->url()
                                ->placeholder('https://example.com/product')
                                ->columnSpan(1),
                        ]),
                    ]),

                Section::make('Settings')
                    ->description('Ad scheduling and expiration')
                    ->schema([
                        DateTimePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->nullable()
                            ->helperText('Leave empty for no expiration')
                            ->minDate(now())
                            ->columnSpanFull(),
                    ]),

                Section::make('Statistics')
                    ->description('Ad performance metrics')
                    ->schema([
                        Grid::make(3)->schema([
                            Placeholder::make('views')
                                ->label('Views')
                                ->content(fn (?Ad $record): string => $record ? number_format($record->views) : '0'),

                            Placeholder::make('clicks')
                                ->label('Clicks')
                                ->content(fn (?Ad $record): string => $record ? number_format($record->clicks) : '0'),

                            Placeholder::make('ctr')
                                ->label('Click-through Rate')
                                ->content(fn (?Ad $record): string => $record ? $record->click_through_rate . '%' : '0%'),
                        ]),
                    ])
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl('/images/placeholder.png'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('product.name')
                    ->label('Linked Product')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No product linked')
                    ->color('gray'),

                TextColumn::make('button_text')
                    ->label('Button')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('views')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('clicks')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('click_through_rate')
                    ->suffix('%')
                    ->numeric(2)
                    ->sortable()
                    ->alignEnd()
                    ->color(fn ($state) => $state > 5 ? 'success' : ($state > 2 ? 'warning' : 'danger')),

                TextColumn::make('status_text')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => match($record->status_text) {
                        'Active' => 'success',
                        'Expired' => 'warning',
                        'Inactive' => 'danger',
                        default => 'gray'
                    }),

                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never')
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : 'gray'),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),

                Filter::make('has_product')
                    ->label('Has Linked Product')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('product_id')),

                Filter::make('expired')
                    ->label('Expired Ads')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<=', now())),

                Filter::make('high_performance')
                    ->label('High Performance (CTR > 5%)')
                    ->query(function (Builder $query): Builder {
                        return $query->whereRaw('(clicks / GREATEST(views, 1)) * 100 > 5');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Tables\Actions\Action::make('reset_stats')
                    ->label('Reset Stats')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Ad $record) {
                        $record->update([
                            'views' => 0,
                            'clicks' => 0,
                        ]);
                    })
                    ->modalHeading('Reset Ad Statistics')
                    ->modalDescription('Are you sure you want to reset the views and clicks for this ad? This action cannot be undone.')
                    ->modalSubmitActionLabel('Reset Statistics'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => true]);
                        }),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => false]);
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::active()->count();
        return $count > 0 ? 'success' : 'danger';
    }
}