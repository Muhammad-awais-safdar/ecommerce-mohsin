<?php

namespace App\Providers;

use App\Events\OfferStatusUpdated;
use App\Events\LoginActivityLogged;
use App\Events\RefundStatusUpdated;
use App\Listeners\LogLoginActivity;
use App\Events\TrackingStatusUpdated;
use App\Listeners\SendOfferStatusMail;
use App\Listeners\SendTrackingStatusEmail;
use App\Listeners\SendRefundStatusUpdateMail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     */
    protected $listen = [
        RefundStatusUpdated::class => [
            SendRefundStatusUpdateMail::class,
        ],
        TrackingStatusUpdated::class => [
            SendTrackingStatusEmail::class,
        ],
        OfferStatusUpdated::class => [
            SendOfferStatusMail::class,
        ],
        LoginActivityLogged::class => [
            LogLoginActivity::class,
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
