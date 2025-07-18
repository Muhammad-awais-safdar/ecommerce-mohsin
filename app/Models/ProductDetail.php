<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'brand',
        'category',
        'weight',
        'dimensions',
        'color',
        'size',
        'material',
        'warranty',
        'specifications'
    ];

    protected $casts = [
        'specifications' => 'array',
        'dimensions' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
