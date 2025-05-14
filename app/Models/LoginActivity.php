<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'location',
        'isp',
        'platform',
        'device_type',
        'browser',
        'user_agent',
        'session_hash',
        'is_notified',
    ];

    /**
     * The user associated with the login activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
