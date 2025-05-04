<?php 

namespace App\Filament\Resources\ThemeSettingResource\Pages;

use App\Filament\Resources\ThemeSettingResource;
use Filament\Resources\Pages\ManageRecords;

class ManageThemeSettings extends ManageRecords
{
    protected static string $resource = ThemeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return []; // Disable "Create" button
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