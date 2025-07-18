<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'reserved_quantity',
        'minimum_stock_level',
        'reorder_point',
        'location',
        'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reserved_quantity' => 'integer',
        'minimum_stock_level' => 'integer',
        'reorder_point' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getAvailableQuantityAttribute()
    {
        return $this->quantity - $this->reserved_quantity;
    }

    public function isLowStock()
    {
        return $this->available_quantity <= $this->minimum_stock_level;
    }

    public function needsReorder()
    {
        return $this->available_quantity <= $this->reorder_point;
    }
}
