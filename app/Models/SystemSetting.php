<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Models\EnvSetting;

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
            // Parse whitelist IPs from env, comma-separated
            $allowIps = array_values(array_filter(array_map('trim', explode(',', (string) env('MAINTENANCE_ALLOW_IPS', '')))));

            // Auto-include current admin IP so they remain whitelisted
            $currentIp = request()->ip() ?? null;
            if ($currentIp && !in_array($currentIp, $allowIps, true)) {
                $allowIps[] = $currentIp;
                // Persist back to .env so it's kept for future toggles
                try {
                    EnvSetting::updateEnvVariable('MAINTENANCE_ALLOW_IPS', implode(', ', $allowIps));
                } catch (\Throwable $e) {
                    // Failing to write .env should not block maintenance action
                }
            }

            $options = [
                '--render' => 'errors.maintenance',
                '--secret' => env('MAINTENANCE_SECRET', 'admin-secret-key'),
                '--with-secret' => true,
            ];

            if (!empty($allowIps)) {
                $options['--allow'] = $allowIps; // allowlist IPs
            }

            Artisan::call('down', $options);
            self::set('maintenance_mode', true, 'boolean', 'Website maintenance mode status');
            return true;
        }
    }

    public static function isMaintenanceMode()
    {
        return app()->isDownForMaintenance() || self::get('maintenance_mode', false);
    }
}
