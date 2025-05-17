<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use SoftDeletes, LogsActivityGlobally;

protected $fillable = ['page', 'meta_title', 'meta_description', 'meta_keywords', 'og_title', 'og_image', 'canonical_url', 'robots', 'twitter_title', 'twitter_image'];

    //
}
