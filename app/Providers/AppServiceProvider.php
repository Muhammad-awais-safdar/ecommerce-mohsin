<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use App\Services\SeoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            Artisan::starting(function ($artisan) {
                $command = $artisan->output();

                // Block migrate:fresh and migrate:refresh
                $forbiddenCommands = ['migrate:fresh', 'migrate:refresh'];

                if (in_array($artisan->getName(), $forbiddenCommands)) {
                    exit("The {$artisan->getName()} command is disabled in production environment.\n");
                }
            });
        }
        View::composer('*', function ($view) {
            $seo = app(SeoService::class)->getSeoData();
            $view->with('seo', $seo);
        });
    }
}
