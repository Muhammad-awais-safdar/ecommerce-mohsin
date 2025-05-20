<?php

namespace App\Listeners;

use App\Events\TrackingStatusUpdated;
use App\Mail\TrackingStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;

class SendTrackingStatusEmail
{
    public function handle(TrackingStatusUpdated $event)
    {
        $order = $event->order;
        Mail::to($order->customer_email)->send(new TrackingStatusUpdatedMail($order));
    }
}
