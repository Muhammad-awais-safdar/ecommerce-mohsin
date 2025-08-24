<?php

namespace App\Filament\Resources;

use App\Models\EnvSetting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\EnvSettingResource\Pages;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EnvSettingResource extends Resource
{
    protected static ?string $model = EnvSetting::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Environment Settings';
   
    protected static ?int $navigationSort = 99;

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
                Placeholder::make('warning')
                    ->content('⚠️ Warning: Changing these settings can break your application. Only modify values if you understand their impact.')
                    ->columnSpanFull(),
                    
                TextInput::make('key')
                    ->label('Environment Variable')
                    ->disabled()
                    ->dehydrated(false),
                    
                TextInput::make('description')
                    ->label('Description')
                    ->disabled()
                    ->dehydrated(false),
                    
                TextInput::make('value')
                    ->label('Value')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $get) {
                        // Update the .env file immediately
                        $key = $get('key');
                        if ($key) {
                            try {
                                EnvSetting::updateEnvVariable($key, $state);
                                
                                Notification::make()
                                    ->title('Environment variable updated successfully')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Error updating environment variable')
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }
                    }),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                // Create a fake query builder for our custom data
                $variables = EnvSetting::getSafeEnvVariables();
                
                return collect($variables)->map(function ($var) {
                    $model = new EnvSetting();
                    $model->key = $var['key'];
                    $model->value = $var['value'];
                    $model->description = $var['description'];
                    $model->type = $var['type'];
                    $model->id = $var['key']; // Use key as ID
                    return $model;
                });
            })
            ->columns([
                TextColumn::make('key')
                    ->label('Variable')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable(),
                    
                TextColumn::make('value')
                    ->label('Current Value')
                    ->limit(50)
                    ->formatStateUsing(function ($state, $record) {
                        // Hide sensitive values
                        if (str_contains(strtolower($record->key), 'password') || 
                            str_contains(strtolower($record->key), 'secret') ||
                            str_contains(strtolower($record->key), 'key')) {
                            return str_repeat('*', min(strlen($state), 8));
                        }
                        return $state;
                    }),
                    
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boolean' => 'success',
                        'password' => 'danger',
                        'email' => 'info',
                        'url' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        Grid::make(1)->schema([
                            Placeholder::make('warning')
                                ->content('⚠️ Warning: Changing these settings can break your application.')
                                ->columnSpanFull(),
                                
                            TextInput::make('key')
                                ->label('Environment Variable')
                                ->disabled(),
                                
                            TextInput::make('description')
                                ->label('Description')
                                ->disabled(),
                                
                            TextInput::make('value')
                                ->label('Value')
                                ->required()
                                ->password(fn ($record) => $record->type === 'password'),
                        ]),
                    ])
                    ->action(function (array $data, $record): void {
                        try {
                            EnvSetting::updateEnvVariable($record->key, $data['value']);
                            
                            Notification::make()
                                ->title('Environment variable updated successfully')
                                ->body("Updated {$record->key}")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error updating environment variable')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([])
            ->defaultSort('key');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnvSettings::route('/'),
        ];
    }
}
