<?php

namespace App\Filament\Resources;

use App\Models\SystemSetting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\CreateAction;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\SystemSettingResource\Pages;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class SystemSettingResource extends Resource
{
    protected static ?string $model = SystemSetting::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    
    protected static ?string $navigationLabel = 'System Settings';
        
    protected static ?int $navigationSort = 98;

    protected static ?string $navigationGroup = 'Awais access';
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)->schema([
                Placeholder::make('info')
                    ->content('⚙️ System settings control core functionality of your application.')
                    ->columnSpanFull(),
                    
                TextInput::make('key')
                    ->label('Setting Key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., maintenance_mode, max_upload_size'),
                    
                TextInput::make('description')
                    ->label('Description')
                    ->placeholder('Brief description of what this setting controls'),
                    
                TextInput::make('value')
                    ->label('Value')
                    ->required()
                    ->placeholder('Setting value'),
                    
                TextInput::make('type')
                    ->label('Type')
                    ->default('string')
                    ->placeholder('string, boolean, integer, json'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Setting Key')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                    
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable(),
                    
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(30)
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type === 'boolean') {
                            return $state ? 'Enabled' : 'Disabled';
                        }
                        return is_array($state) ? json_encode($state) : $state;
                    }),
                    
                IconColumn::make('type')
                    ->label('Type')
                    ->icon(fn (string $state): string => match ($state) {
                        'boolean' => 'heroicon-o-check-circle',
                        'integer' => 'heroicon-o-hashtag',
                        'json' => 'heroicon-o-code-bracket',
                        default => 'heroicon-o-document-text',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'boolean' => 'success',
                        'integer' => 'info',
                        'json' => 'warning',
                        default => 'gray',
                    }),
                    
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->defaultSort('key');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSystemSettings::route('/'),
            'create' => Pages\CreateSystemSetting::route('/create'),
            'edit' => Pages\EditSystemSetting::route('/{record}/edit'),
        ];
    }
}
