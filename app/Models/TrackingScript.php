<?php

namespace App\Models;

use App\Traits\LogsActivityGlobally;
use Illuminate\Database\Eloquent\Model;

class TrackingScript extends Model
{
    use LogsActivityGlobally;

    protected $fillable = [
        'name',
        'location',
        'script',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getLocationOptions(): array
    {
        return [
            'head' => 'Head',
            'body_end' => 'Body End',
        ];
    }
}
