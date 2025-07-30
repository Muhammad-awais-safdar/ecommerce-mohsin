<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use App\Traits\LogsActivityGlobally;

class Ad extends Model
{
    use HasFactory, LogsActivityGlobally;

    protected $fillable = [
        'title',
        'description',
        'product_id',
        'custom_image',
        'button_text',
        'button_link',
        'is_active',
        'views',
        'clicks',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
        'clicks' => 'integer',
        'expires_at' => 'datetime',
    ];

    /**
     * Relationship with Product model
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the image URL for the ad
     * Returns custom image if available, otherwise product image
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->custom_image) {
            return asset('storage/' . $this->custom_image);
        }

        if ($this->product && $this->product->images) {
            $images = is_array($this->product->images) ? $this->product->images : json_decode($this->product->images, true);
            if (!empty($images)) {
                return asset('storage/products/' . $images[0]);
            }
        }

        return null;
    }

    /**
     * Get the primary image URL for the ad (prioritizes custom_image)
     */
    public function getPrimaryImageUrlAttribute(): ?string
    {
        return $this->custom_image ? asset('storage/' . $this->custom_image) : null;
    }

    /**
     * Check if ad has a valid image
     */
    public function hasValidImage(): bool
    {
        return !empty($this->image_url);
    }

    /**
     * Scope to get only active and non-expired ads
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope to get expired ads
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Check if the ad is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get click-through rate
     */
    public function getClickThroughRateAttribute(): float
    {
        if ($this->views === 0) {
            return 0;
        }

        return round(($this->clicks / $this->views) * 100, 2);
    }

    /**
     * Increment views counter
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Increment clicks counter
     */
    public function incrementClicks(): void
    {
        $this->increment('clicks');
    }

    /**
     * Get a random active ad
     */
    public static function getRandomActiveAd(): ?self
    {
        return self::active()->inRandomOrder()->first();
    }

    /**
     * Get status badge color for Filament
     */
    public function getStatusColorAttribute(): string
    {
        if (!$this->is_active) {
            return 'danger';
        }

        if ($this->is_expired) {
            return 'warning';
        }

        return 'success';
    }

    /**
     * Get status text for Filament
     */
    public function getStatusTextAttribute(): string
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        if ($this->is_expired) {
            return 'Expired';
        }

        return 'Active';
    }
}