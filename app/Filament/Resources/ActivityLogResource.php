<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ActivityLogResource\Pages;
use App\Filament\Resources\ActivityLogResource\Pages\ViewActivityLog;
use App\Filament\Resources\ActivityLogResource\Pages\ListActivityLogs;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Activity Logs';
    protected static ?string $navigationGroup = 'Awais access';
    protected static ?string $pluralModelLabel = 'Activity Logs';
    protected static ?string $modelLabel = 'Activity Log';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Activity::whereDate('created_at', now())->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('causer');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$search}%"));
                    })
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->leftJoin('users', 'users.id', '=', 'activity_log.causer_id')
                            ->orderBy('users.name', $direction)
                            ->select('activity_log.*');
                    })
                    ->default('System'),

                TextColumn::make('log_name')
                    ->label('Model')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn(string $state) => match ($state) {
                        'created' => 'heroicon-o-plus',
                        'updated' => 'heroicon-o-pencil',
                        'deleted' => 'heroicon-o-trash',
                        default => 'heroicon-o-information-circle',
                    }),

                TextColumn::make('subject_id')
                    ->label('Record ID')
                    ->sortable(),

                TextColumn::make('properties')
                    ->label('IP Address')
                    ->getStateUsing(function ($record) {
                        return $record->properties['ip_address'] ?? 'N/A';
                    })
                    ->searchable(false)
                    ->sortable(false),

                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),

                ViewColumn::make('properties')
                    ->label('Changes')
                    ->view('filament.tables.columns.activity-properties'),
            ])
            ->filters([
                SelectFilter::make('causer_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id')->toArray())
                    ->multiple(),

                SelectFilter::make('log_name')
                    ->label('Model')
                    ->options(fn() => Activity::query()
                        ->select('log_name')
                        ->distinct()
                        ->pluck('log_name', 'log_name')
                        ->toArray())
                    ->multiple(),

                SelectFilter::make('description')
                    ->label('Action')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ])
                    ->multiple(),

                \Filament\Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                ViewAction::make()
                    ->modalHeading(fn(Activity $record) => 'Activity Log Details')
                    ->modalSubheading(fn(Activity $record) => 'Action: ' . ucfirst($record->description) . ' on ' . $record->log_name)
                    ->form([
                        \Filament\Forms\Components\Section::make('User Information')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('user')
                                    ->label('User')
                                    ->content(fn(Activity $record) => optional($record->causer)->name ?? 'System'),

                                \Filament\Forms\Components\Placeholder::make('user_email')
                                    ->label('Email')
                                    ->content(fn(Activity $record) => optional($record->causer)->email ?? 'N/A'),
                            ])
                            ->columns(2),

                        \Filament\Forms\Components\Section::make('Action Details')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('model')
                                    ->label('Model')
                                    ->content(fn(Activity $record) => $record->log_name),

                                \Filament\Forms\Components\Placeholder::make('action')
                                    ->label('Action')
                                    ->content(fn(Activity $record) => ucfirst($record->description)),

                                \Filament\Forms\Components\Placeholder::make('record_id')
                                    ->label('Record ID')
                                    ->content(fn(Activity $record) => $record->subject_id ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('time')
                                    ->label('Time')
                                    ->content(fn(Activity $record) => $record->created_at->format('d M Y, h:i A')),
                            ])
                            ->columns(2),

                        \Filament\Forms\Components\Section::make('Request Information')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('ip')
                                    ->label('IP Address')
                                    ->content(fn(Activity $record) => $record->properties['ip_address'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('url')
                                    ->label('URL')
                                    ->content(fn(Activity $record) => $record->properties['url'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('method')
                                    ->label('HTTP Method')
                                    ->content(fn(Activity $record) => $record->properties['method'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('user_agent')
                                    ->label('User Agent')
                                    ->content(fn(Activity $record) => $record->properties['user_agent'] ?? 'N/A'),
                            ])
                            ->columns(2),

                        \Filament\Forms\Components\Section::make('Data Changes')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('changes')
                                    ->label('Changes')
                                    ->content(function (Activity $record) {
                                        return view('filament.tables.columns.activity-properties', [
                                            'changes' => $record->properties->toArray()
                                        ])->render();
                                    }),
                            ]),
                    ]),
                \Filament\Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
