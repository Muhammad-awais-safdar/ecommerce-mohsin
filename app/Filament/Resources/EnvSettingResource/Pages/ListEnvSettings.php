<?php

namespace App\Filament\Resources\EnvSettingResource\Pages;

use App\Filament\Resources\EnvSettingResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class ListEnvSettings extends ListRecords
{
    protected static string $resource = EnvSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('maintenance_mode')
                ->label('Toggle Maintenance Mode')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Toggle Maintenance Mode')
                ->modalDescription('This will put the website in/out of maintenance mode. Customers will see a maintenance page.')
                ->action(function (): void {
                    try {
                        $enabled = \App\Models\SystemSetting::toggleMaintenanceMode();
                        if ($enabled) {
                            Notification::make()
                                ->title('Maintenance mode enabled')
                                ->body('Your IP has been auto-added to the allowlist. Use ?secret=' . env('MAINTENANCE_SECRET', 'admin-secret-key') . ' if needed.')
                                ->warning()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Maintenance mode disabled')
                                ->body('Website is now live for customers')
                                ->success()
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
                
            Action::make('clear_cache')
                ->label('Clear All Cache')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        Artisan::call('cache:clear');
                        Artisan::call('config:clear');
                        Artisan::call('route:clear');
                        Artisan::call('view:clear');
                        
                        Notification::make()
                            ->title('All caches cleared successfully')
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
        ];
    }
}
