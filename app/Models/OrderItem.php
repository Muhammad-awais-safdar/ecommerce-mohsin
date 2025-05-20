<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use SoftDeletes, LogsActivityGlobally;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function product()
{
    return $this->belongsTo(Product::class);
}


}
