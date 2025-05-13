<?php

namespace App\Filament\Resources\ThemeSettingResource\Pages;

use App\Filament\Resources\ThemeSettingResource;
use Filament\Actions\Action;
use App\Models\ThemeSetting;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageThemeSettings extends ManageRecords
{
    protected static string $resource = ThemeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reset_colors')
                ->label('Reset Theme')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $defaultColors = [
                        'color_background' => '#ffffff',
                        'color_text_primary' => '#2C2C2C',
                        'color_text_secondary' => '#8C8C8C',
                        'color_accent_primary' => '#C7A200',
                        'color_accent_secondary' => '#FFD700',
                        'color_border' => '#DDD6C5',
                    ];

                    foreach ($defaultColors as $key => $value) {
                        ThemeSetting::updateOrCreate(
                            ['key' => $key],
                            ['value' => $value]
                        );
                    }

                    Notification::make()
                        ->title('Theme colors have been reset to default.')
                        ->success()
                        ->send();
                }),
            Action::make('Migrate')
                ->color('success')
                ->icon('heroicon-o-adjustments-horizontal')
                ->action(function () {
                    Artisan::call('migrate', ['--force' => true]);
                    $this->notify('success', 'Migration completed');
                }),

            Action::make('Storage Link')
                ->color('warning')
                ->icon('heroicon-o-link')
                ->action(function () {
                    Artisan::call('storage:link');
                    $this->notify('success', 'Storage linked');
                }),

            Action::make('Optimize')
                ->color('primary')
                ->icon('heroicon-o-bolt')
                ->action(function () {
                    Artisan::call('optimize');
                    $this->notify('success', 'Application optimized');
                }),

            Action::make('Clear Cache')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->action(function () {
                    Artisan::call('optimize:clear');
                    Artisan::call('cache:clear');
                    Artisan::call('config:clear');
                    Artisan::call('route:clear');
                    Artisan::call('view:clear');
                    $this->notify('success', 'All caches cleared');
                }),

            Action::make('Seed DB')
                ->color('gray')
                ->icon('heroicon-o-adjustments-horizontal')
                ->action(function () {
                    Artisan::call('db:seed', ['--force' => true]);
                    $this->notify('success', 'Database seeding complete');
                }),
        ];
    }

    public function isTableSearchable(): bool
    {
        return false; // Optional: disable search if you want
    }

    public function isTablePaginationEnabled(): bool
    {
        return false; // Optional: show all colors in one page
    }
}
