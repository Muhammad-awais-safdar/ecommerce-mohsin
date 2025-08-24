<?php

namespace App\Filament\Resources\SystemSettingResource\Pages;

use App\Filament\Resources\SystemSettingResource;
use App\Models\SystemSetting;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class ListSystemSettings extends ListRecords
{
    protected static string $resource = SystemSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('maintenance_mode')
                ->label(function () {
                    return app()->isDownForMaintenance() ? 'Disable Maintenance' : 'Enable Maintenance';
                })
                ->icon(function () {
                    return app()->isDownForMaintenance() ? 'heroicon-o-play' : 'heroicon-o-pause';
                })
                ->color(function () {
                    return app()->isDownForMaintenance() ? 'success' : 'warning';
                })
                ->requiresConfirmation()
                ->modalHeading(function () {
                    return app()->isDownForMaintenance() ? 'Disable Maintenance Mode' : 'Enable Maintenance Mode';
                })
                ->modalDescription(function () {
                    return app()->isDownForMaintenance() 
                        ? 'This will make the website live for all customers again.'
                        : 'This will put the website in maintenance mode. Only admins with the secret key can access it.';
                })
                ->action(function (): void {
                    try {
                        $wasDown = SystemSetting::toggleMaintenanceMode();
                        
                        if ($wasDown) {
                            Notification::make()
                                ->title('Maintenance mode disabled')
                                ->body('Website is now live for customers')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Maintenance mode enabled')
                                ->body('Website is in maintenance mode. Use ?secret=admin-secret-key to bypass.')
                                ->warning()
                                ->send();
                        }
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error toggling maintenance mode')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
                
            Action::make('optimize_app')
                ->label('Optimize Application')
                ->icon('heroicon-o-rocket-launch')
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Optimize Application')
                ->modalDescription('This will run optimization commands to improve performance.')
                ->action(function (): void {
                    try {
                        Artisan::call('optimize');
                        Artisan::call('config:cache');
                        Artisan::call('route:cache');
                        Artisan::call('view:cache');
                        
                        Notification::make()
                            ->title('Application optimized successfully')
                            ->body('Config, routes, and views have been cached for better performance')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error optimizing application')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
                
            Action::make('clear_all_cache')
                ->label('Clear All Cache')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Clear All Cache')
                ->modalDescription('This will clear all application caches including config, routes, views, and data cache.')
                ->action(function (): void {
                    try {
                        Artisan::call('cache:clear');
                        Artisan::call('config:clear');
                        Artisan::call('route:clear');
                        Artisan::call('view:clear');
                        
                        // Clear custom caches
                        app(\App\Services\ProductCacheService::class)->clearAllProductCache();
                        
                        Notification::make()
                            ->title('All caches cleared successfully')
                            ->body('Application cache, config, routes, views, and product cache cleared')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error clearing cache')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
                
            CreateAction::make()
                ->label('Add Setting'),
        ];
    }
}
