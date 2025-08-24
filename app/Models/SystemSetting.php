<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get($key, $default = null)
    {
        $setting = Cache::remember("system_setting_{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'string', $description = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description
            ]
        );

        Cache::forget("system_setting_{$key}");
        
        return $setting;
    }

    public static function toggleMaintenanceMode()
    {
        $isDown = app()->isDownForMaintenance();
        
        if ($isDown) {
            Artisan::call('up');
            self::set('maintenance_mode', false, 'boolean', 'Website maintenance mode status');
            return false;
        } else {
            Artisan::call('down', [
                '--render' => 'errors.maintenance',
                '--secret' => 'admin-secret-key',
                '--with-secret' => true,
            ]);
            self::set('maintenance_mode', true, 'boolean', 'Website maintenance mode status');
            return true;
        }
    }

    public static function isMaintenanceMode()
    {
        return app()->isDownForMaintenance() || self::get('maintenance_mode', false);
    }
}
