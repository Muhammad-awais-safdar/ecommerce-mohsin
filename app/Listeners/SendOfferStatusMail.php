<?php

namespace App\Listeners;

use App\Events\OfferStatusUpdated;
use App\Mail\OfferStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOfferStatusMail implements ShouldQueue
{
    public function handle(OfferStatusUpdated $event)
    {
        if ($event->offer->email) {
            Mail::to($event->offer->email)->send(new OfferStatusNotification($event->offer));
        }
    }
}
