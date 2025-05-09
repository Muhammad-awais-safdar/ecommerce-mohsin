<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'image', 'discount_percentage'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount_percentage) {
            return round($this->price - ($this->price * $this->discount_percentage / 100), 2);
        }
        return $this->price;
    }
    protected $casts = [
        'images' => 'array',
    ];
}
