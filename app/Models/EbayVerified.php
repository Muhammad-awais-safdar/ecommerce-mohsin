<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EbayVerified extends Model
{
    protected $table = 'ebay_verifieds';
    protected $fillable = [
        'imagePath',
        'imageName',
    ];
}
