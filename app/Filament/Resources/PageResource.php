<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationLabel = 'Pages';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input for Page Name at the top
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Page Name') // Label for the name input field
                    ->placeholder('Enter the page name here')
                    ->helperText('This will be the title of your page')
                    ->columnSpan('full'), // Make the input span the full width,

                // Large Rich Editor for Content at the bottom
                RichEditor::make('content')
                    ->required()
                    ->label('Page Content') // Label for the editor
                    ->placeholder('Write the content of your page here...')
                    ->disableToolbarButtons(['attachFiles', 'codeBlock',]) // Disable certain buttons
                    ->maxLength(65535)
                    ->columnSpan('full') // Make the editor span the full width
                    ->helperText('Use the editor to add content to your page'),

                // You can add more fields here as needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->schema([
                 // Input for Page Name at the top
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Page Name') // Label for the name input field
                    ->placeholder('Enter the page name here')
                    ->helperText('This will be the title of your page'),

                // Large Rich Editor for Content at the bottom
                RichEditor::make('content')
                    ->required()
                    ->label('Page Content') // Label for the editor
                    ->placeholder('Write the content of your page here...')
                    ->columnSpan('full') // Make the editor span the full width
                    ->disableToolbarButtons(['attachFiles', 'codeBlock',]) // Disable certain buttons
                    ->maxLength(65535)
                    ->helperText('Use the editor to add content to your page'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn(Page $record) => route('filament.resources.pages.edit', $record))
                    ->label('Edit'),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}