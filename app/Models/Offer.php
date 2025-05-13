<?php

namespace App\Models;

use App\Events\OfferStatusUpdated;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'email',
        'phone',
        'offer_price',
        'quantity',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    } //
    protected static function booted()
    {
        static::updated(function ($offer) {
            if ($offer->isDirty('status')) {
                event(new OfferStatusUpdated($offer));
            }
        });
    }
}
