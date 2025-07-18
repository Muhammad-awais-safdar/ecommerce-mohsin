<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserActivityResource\Pages;

class UserActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'User Activity';
    protected static ?string $navigationGroup = 'Awais access';
    protected static ?string $pluralModelLabel = 'User Activities';
    protected static ?string $modelLabel = 'User Activity';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }
    public static function getNavigationBadge(): ?string
    {
        return (string) Activity::whereNotNull('causer_id')
            ->whereDate('created_at', now())
            ->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('causer')
            ->whereNotNull('causer_id')
            ->whereNotIn('log_name', ['Product', 'Order', 'User', 'Review', 'Offer', 'EbayVerified', 'Seo']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
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
                    }),

                TextColumn::make('causer.email')
                    ->label('Email')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->orWhereHas('causer', fn($q) => $q->where('email', 'like', "%{$search}%"));
                    })
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->leftJoin('users', 'users.id', '=', 'activity_log.causer_id')
                            ->orderBy('users.email', $direction)
                            ->select('activity_log.*');
                    }),

                TextColumn::make('description')
                    ->label('Activity')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('properties')
                    ->label('Page/URL')
                    ->getStateUsing(function ($record) {
                        $url = $record->properties['url'] ?? 'N/A';
                        return str_replace(url('/'), '', $url);
                    })
                    ->wrap(),

                TextColumn::make('properties')
                    ->label('IP Address')
                    ->getStateUsing(function ($record) {
                        return $record->properties['ip_address'] ?? 'N/A';
                    }),

                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('causer_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id')->toArray())
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
                    ->modalHeading(fn(Activity $record) => 'User Activity Details')
                    ->modalSubheading(fn(Activity $record) => 'User: ' . optional($record->causer)->name)
                    ->form([
                        \Filament\Forms\Components\Section::make('User Information')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('user')
                                    ->label('User Name')
                                    ->content(fn(Activity $record) => optional($record->causer)->name ?? 'Unknown'),

                                \Filament\Forms\Components\Placeholder::make('user_email')
                                    ->label('Email')
                                    ->content(fn(Activity $record) => optional($record->causer)->email ?? 'N/A'),
                            ])
                            ->columns(2),

                        \Filament\Forms\Components\Section::make('Activity Details')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('activity')
                                    ->label('Activity')
                                    ->content(fn(Activity $record) => $record->description),

                                \Filament\Forms\Components\Placeholder::make('time')
                                    ->label('Time')
                                    ->content(fn(Activity $record) => $record->created_at->format('d M Y, h:i A')),

                                \Filament\Forms\Components\Placeholder::make('url')
                                    ->label('URL')
                                    ->content(fn(Activity $record) => $record->properties['url'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('route')
                                    ->label('Route Name')
                                    ->content(fn(Activity $record) => $record->properties['route_name'] ?? 'N/A'),
                            ])
                            ->columns(2),

                        \Filament\Forms\Components\Section::make('Technical Details')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('ip')
                                    ->label('IP Address')
                                    ->content(fn(Activity $record) => $record->properties['ip_address'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('method')
                                    ->label('HTTP Method')
                                    ->content(fn(Activity $record) => $record->properties['method'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('user_agent')
                                    ->label('User Agent')
                                    ->content(fn(Activity $record) => $record->properties['user_agent'] ?? 'N/A'),

                                \Filament\Forms\Components\Placeholder::make('parameters')
                                    ->label('Route Parameters')
                                    ->content(function (Activity $record) {
                                        $params = $record->properties['parameters'] ?? [];
                                        return empty($params) ? 'N/A' : json_encode($params, JSON_PRETTY_PRINT);
                                    }),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserActivities::route('/'),
        ];
    }
}