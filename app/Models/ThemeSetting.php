<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use SoftDeletes, LogsActivityGlobally;
    protected $fillable = [
        "key",
        "value",
    ];
}
