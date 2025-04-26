<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RefundRequest extends Model
{
    protected $fillable = ['order_id', 'customer_name', 'customer_email', 'customer_phone', 'reason', 'status'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}