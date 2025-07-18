<?php

namespace App\Filament\Widgets;

use App\Services\ActivityLogService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivities extends BaseWidget
{
    protected static ?string $heading = 'Recent Activities';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $activityService = app(ActivityLogService::class);
        $activities = $activityService->getRecentActivities(10);

        return $table
            ->query(
                \Spatie\Activitylog\Models\Activity::query()
                    ->with('causer')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('log_name')
                    ->label('Model')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('Record ID'),

                Tables\Columns\TextColumn::make('properties')
                    ->label('IP')
                    ->getStateUsing(function ($record) {
                        return $record->properties['ip_address'] ?? 'N/A';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->paginated(false);
    }
}