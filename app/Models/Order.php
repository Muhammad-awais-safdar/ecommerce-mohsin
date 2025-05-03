<?php

namespace App\Models;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'customer_phone', 'shipping_address', 'total_amount', 'status'];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}