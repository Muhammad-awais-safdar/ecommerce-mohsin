<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Generate Sitemap')
                ->label('🧭 Generate Sitemap')
                ->color('success')
                ->action(function () {
                    Artisan::call('app:generate-sitemap');


                    Notification::make()
                        ->title('Sitemap generated successfully!')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->icon('heroicon-o-map'),
                  Action::make('view_sitemap')
            ->label('🔍 View Sitemap')
            ->url(url('/sitemap.xml')) // or use your Blade route: url('/sitemap-view')
            ->openUrlInNewTab()
            ->color('gray')
            ->icon('heroicon-o-eye'),
               Action::make('view_robots_txt')
            ->label('👁️ View robots.txt')
            ->url(url('/robots.txt')) // or use Blade route if required
            ->openUrlInNewTab()
            ->color('gray')
            ->icon('heroicon-o-eye'),
        ];
    }
}