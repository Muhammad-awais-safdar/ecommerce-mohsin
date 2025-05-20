<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
// use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
// use Filament\Resources\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('product_id')
                ->relationship('product', 'name')
                ->label('Product')
                ->required(),

            TextInput::make('user_name')
                ->label('Reviewer Name')
                ->required(),

            TextInput::make('rating')
                ->label('Rating (1–5)')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->required(),

            Textarea::make('comment')
                ->label('Comment')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('product.name')
                    ->label('Product')
                    ->collapsible(),  // allow each product group to be collapsed :contentReference[oaicite:0]{index=0}
            ])
            // 2) optionally set it as the default grouping
            ->defaultGroup('product.name')
            ->columns([
                TextColumn::make('user_name')
                    ->label('Reviewer')
                    ->searchable(),

                TextColumn::make('rating'),

                TextColumn::make('comment')
                    ->limit(50),

                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
