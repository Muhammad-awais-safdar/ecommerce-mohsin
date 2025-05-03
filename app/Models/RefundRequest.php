<?php

namespace App\Models;
use App\Events\RefundStatusUpdated;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $fillable = ['order_id', 'customer_name', "customer_phone", 'customer_email', 'reason', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected static function booted()
    {
        static::updated(function ($refundRequest) {
            // Check if the status field was updated
            if ($refundRequest->isDirty('status')) {
                // Trigger the event with the updated status
                event(new RefundStatusUpdated(
                    $refundRequest->order, // Pass the related Order
                    $refundRequest->status // Pass the new status
                ));
            }
        });
    }
}