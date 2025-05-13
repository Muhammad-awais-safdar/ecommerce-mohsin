<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     */
    protected $listen = [
        \App\Events\RefundStatusUpdated::class => [
            \App\Listeners\SendRefundStatusUpdateMail::class,
        ],
        \App\Events\TrackingStatusUpdated::class => [
            \App\Listeners\SendTrackingStatusEmail::class,
        ],
    ];

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
        //
    }
}
