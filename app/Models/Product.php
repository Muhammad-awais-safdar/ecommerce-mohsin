<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes, LogsActivityGlobally;
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'price', 'images', 'discount_percentage'];

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
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
