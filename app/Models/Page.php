<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivityGlobally;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes, LogsActivityGlobally;
    protected $fillable = ['slug', 'name', 'content'];

    public function getRouteKeyName()
    {
        return 'slug';  // This assumes you have a slug field for SEO-friendly URLs
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $page->slug = Str::slug($page->name);
        });
    }
}
