<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingScript extends Model
{
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
