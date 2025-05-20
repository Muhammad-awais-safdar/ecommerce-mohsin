<?php

namespace App\Listeners;

use App\Events\RefundStatusUpdated;
use App\Mail\RefundRequestMail;
use Illuminate\Support\Facades\Mail;

class SendRefundStatusUpdateMail
{
    /**
     * Handle the event.
     *
     * @param  RefundStatusUpdated  $event
     * @return void
     */
    public function handle(RefundStatusUpdated $event)
    {
        $order = $event->order;
        $status = $event->status;

        // Send mail to the customer about refund status update
        Mail::to($order->customer_email)->send(new RefundRequestMail($order, $status));
    }
}