<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefundStatusUpdated
{
    use Dispatchable, SerializesModels;

    public $order;
    public $status;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     * @param string $status
     */
    public function __construct(Order $order, string $status)
    {
        $this->order = $order;
        $this->status = $status;
    }
}