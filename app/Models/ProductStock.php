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
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getAvailableQuantityAttribute()
    {
        return $this->quantity;
    }

    public function isLowStock($threshold = 10)
    {
        return $this->quantity <= $threshold;
    }

    public function needsReorder($threshold = 5)
    {
        return $this->quantity <= $threshold;
    }
}
