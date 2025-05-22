<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LoginActivity;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\HtmlString;
use App\Filament\Resources\LoginActivityResource\Pages;

class LoginActivityResource extends Resource
{
    protected static ?string $model = LoginActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Awais access';

    public static function getNavigationBadge(): ?string
    {
        return (string) \App\Models\LoginActivity::whereDate('created_at', now())->count();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Not needed here as you are using view-only modal
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->searchable(),
                TextColumn::make('ip_address')->searchable(),
                TextColumn::make('location')->sortable(),
                TextColumn::make('isp')->sortable(),
                TextColumn::make('platform')->label('OS')->sortable(),
                TextColumn::make('device_type')->label('Device')->sortable(),
                TextColumn::make('browser')->label('Browser')->sortable(),
                TextColumn::make('user_agent')->label('User Agent')->limit(20),
                TextColumn::make('session_hash')->label('Session Hash')->limit(15),
                BooleanColumn::make('is_notified')->label('Notified')->trueIcon('heroicon-o-check')->falseIcon('heroicon-o-bell-alert'),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($state, $record) {
                        $user = $record->user;
                        if (! $user) return new HtmlString('<span class="text-gray-500">Unknown</span>');
                        if ($user->isOnline()) {
                            return new HtmlString('<span class="text-green-500 font-semibold"><svg class="inline w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>Online</span>');
                        }
                        return new HtmlString('<span class="text-gray-500">Last seen: ' . e($user->lastSeen()) . '</span>');
                    })
                    ->html(),

                TextColumn::make('created_at')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('ip_address')
                    ->form([
                        Forms\Components\TextInput::make('ip')->label('IP Address'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['ip'], fn($q, $ip) => $q->where('ip_address', 'like', "%$ip%"));
                    }),

                Tables\Filters\Filter::make('user_name')
                    ->form([
                        Forms\Components\TextInput::make('name')->label('User Name'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['name'], fn($q, $name) => $q->whereHas('user', fn($q) => $q->where('name', 'like', "%$name%")));
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                ViewAction::make()
                    ->label('View Details')
                    ->modalWidth('lg')
                    ->modalHeading('Login Activity Details')
                    ->action(function (LoginActivity $record) {
                        return view('filament.resources.login-activity.view', ['record' => $record]);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListLoginActivities::route('/'),
        ];
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
