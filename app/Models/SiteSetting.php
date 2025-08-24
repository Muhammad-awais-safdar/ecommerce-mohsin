<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use SoftDeletes, LogsActivityGlobally;
protected $fillable = ['robots_txt', 'favicon'];

    //
}
