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
    protected $fillable = ['name', 'slug', 'description', 'price', 'images','status', 'discount_percentage','sku','is_deal','sales_count','total_sales','last_sale_at','publication_status','published_at','published_by'];

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
        'last_sale_at' => 'datetime',
        'published_at' => 'datetime',
        'publication_status' => 'string',
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

    // Publication status relationships and methods
    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    // Scopes for publication status
    public function scopePublished($query)
    {
        return $query->where('publication_status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('publication_status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('publication_status', 'archived');
    }

    // Helper methods for publication status
    public function isDraft(): bool
    {
        return $this->publication_status === 'draft';
    }

    public function isPublished(): bool
    {
        return $this->publication_status === 'published';
    }

    public function isArchived(): bool
    {
        return $this->publication_status === 'archived';
    }

    public function publish($userId = null): bool
    {
        return $this->update([
            'publication_status' => 'published',
            'published_at' => now(),
            'published_by' => $userId ?? auth()->id(),
        ]);
    }

    public function unpublish(): bool
    {
        return $this->update([
            'publication_status' => 'draft',
            'published_at' => null,
            'published_by' => null,
        ]);
    }

    public function archive(): bool
    {
        return $this->update([
            'publication_status' => 'archived',
        ]);
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

    public function decreaseStock($quantity)
    {
        if ($this->stock && $this->stock->quantity >= $quantity) {
            $this->stock->decrement('quantity', $quantity);
            $this->increment('total_sales', $quantity);
            $this->update(['last_sale_at' => now()]);
            return true;
        }
        return false;
    }

    public function getAvailableStockAttribute()
    {
        return $this->stock ? $this->stock->quantity : 0;
    }

    public function getSalesLastHoursAttribute($hours = 3)
    {
        $minSales = 15;
        $maxSales = 50;
        $baseSales = mt_rand($minSales, $maxSales);
        
        $timeFactor = sin(date('H') * pi() / 12) + 1;
        $dayFactor = date('N') <= 5 ? 1.2 : 0.8;
        
        return max(1, round($baseSales * $timeFactor * $dayFactor));
    }

    public function getRandomSalesMessageAttribute()
    {
        $hours = mt_rand(2, 4);
        $sales = $this->getSalesLastHoursAttribute($hours);
        
        $templates = [
            "Previous {$hours} hours: {$sales} sales done",
            "Last {$hours}h: {$sales} customers purchased this item",
            "{$sales} people bought this in the last {$hours} hours",
            "Hot item! {$sales} sold in past {$hours} hours"
        ];
        
        return $templates[array_rand($templates)];
    }

}
