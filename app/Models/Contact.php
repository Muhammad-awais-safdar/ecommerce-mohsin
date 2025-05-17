<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use SoftDeletes, LogsActivityGlobally;
    protected $fillable = ['name', 'email', 'phone', 'company', 'message'];


    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }
}
