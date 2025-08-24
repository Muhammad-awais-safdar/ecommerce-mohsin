<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $status
     * @return void
     */
    public function __construct(Order $order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Set the subject dynamically based on the status
        $subject = "Refund Request - Status: " . ucfirst($this->status);

        return $this->subject($subject)
            ->view('emails.refund-request')
            ->with([
                'order' => $this->order,
                'status' => $this->status,
            ]);
    }
}