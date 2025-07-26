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
    protected $fillable = ['name', 'slug', 'description', 'price', 'images','status', 'discount_percentage','sku','is_deal','sales_count'];

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
            // Create slug from name
            $product->slug = Str::slug($product->name);

            // Generate unique SKU
            do {
                $sku = 'PROD-' . strtoupper(Str::random(6));
            } while (self::where('sku', $sku)->exists());

            $product->sku = $sku;
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }


    // App\Models\Product
    public function scopeFilterByBrand($query, $brand)
    {
        return $query->when($brand, fn($q) => $q->where('brand', $brand));
    }

    // app/Models/Product.php

    public function details()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function stock()
    {
        return $this->hasOne(ProductStock::class);
    }

}
