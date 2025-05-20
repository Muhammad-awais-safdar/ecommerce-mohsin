<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;

class EbayVerified extends Model
{
    use SoftDeletes, LogsActivityGlobally;

    protected $table = 'ebay_verifieds';
    protected $fillable = [
        'imagePath',
        'imageName',
    ];
}
