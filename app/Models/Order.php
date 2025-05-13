<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Events\TrackingStatusUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
        'status',
        'tracking_number',
        'tracking_status',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected static function booted()
    {
        static::updated(function ($order) {
            if ($order->isDirty('tracking_status')) {
                event(new TrackingStatusUpdated($order));
            }
        });
    }
}
