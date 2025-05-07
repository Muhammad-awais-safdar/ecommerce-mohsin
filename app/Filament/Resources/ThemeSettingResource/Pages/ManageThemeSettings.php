<?php

namespace App\Filament\Resources\ThemeSettingResource\Pages;

use App\Filament\Resources\ThemeSettingResource;
use Filament\Actions\Action;
use App\Models\ThemeSetting;
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
