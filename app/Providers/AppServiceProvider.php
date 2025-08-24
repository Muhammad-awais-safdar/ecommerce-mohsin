<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Services\SeoService;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Models\Ad;
use App\Observers\ProductObserver;
use App\Observers\AdObserver;

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
        Product::observe(ProductObserver::class);
        Ad::observe(AdObserver::class);
       
        View::composer('*', function ($view) {
            $seo = app(SeoService::class)->getSeoData();
            $view->with('seo', $seo);
        });

    }
}
