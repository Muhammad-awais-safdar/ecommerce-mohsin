<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['product_id', 'session_id', 'email', 'offer_price', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }//
}
