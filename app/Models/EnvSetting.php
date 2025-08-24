<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvSetting extends Model
{
    protected $fillable = ['key', 'value', 'description', 'type'];

    public static function getEnvVariables()
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        
        $variables = [];
        $lines = explode("\n", $envContent);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $variables[$key] = $value;
            }
        }
        
        return $variables;
    }
    
    public static function updateEnvVariable($key, $value)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        
        // Escape special characters in value
        $value = str_replace('"', '\"', $value);
        
        // If value contains spaces or special characters, wrap in quotes
        if (preg_match('/\s/', $value) || preg_match('/[^a-zA-Z0-9_\-\.]/', $value)) {
            $value = '"' . $value . '"';
        }
        
        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}={$value}";
        
        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, $replacement, $envContent);
        } else {
            $envContent .= "\n{$replacement}";
        }
        
        file_put_contents($envPath, $envContent);
        
        // Clear config cache
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
    }
    
    public static function getSafeEnvVariables()
    {
        $allVars = self::getEnvVariables();
        
        // Define safe variables that can be edited
        $safeKeys = [
            'APP_NAME' => 'Application Name',
            'APP_URL' => 'Application URL',
            'APP_ENV' => 'Environment',
            'APP_DEBUG' => 'Debug Mode',
            'MAIL_MAILER' => 'Mail Driver',
            'MAIL_HOST' => 'Mail Host',
            'MAIL_PORT' => 'Mail Port',
            'MAIL_USERNAME' => 'Mail Username',
            'MAIL_FROM_ADDRESS' => 'Mail From Address',
            'MAIL_FROM_NAME' => 'Mail From Name',
            'STRIPE_KEY' => 'Stripe Public Key',
            'GOOGLE_TRANSLATE_API_KEY' => 'Google Translate API Key',
        ];
        
        $safeVars = [];
        foreach ($safeKeys as $key => $description) {
            $safeVars[] = [
                'key' => $key,
                'value' => $allVars[$key] ?? '',
                'description' => $description,
                'type' => self::getVariableType($key)
            ];
        }
        
        return $safeVars;
    }
    
    private static function getVariableType($key)
    {
        $booleanVars = ['APP_DEBUG'];
        $passwordVars = ['MAIL_PASSWORD', 'STRIPE_SECRET'];
        $urlVars = ['APP_URL'];
        $emailVars = ['MAIL_FROM_ADDRESS', 'MAIL_USERNAME'];
        
        if (in_array($key, $booleanVars)) {
            return 'boolean';
        } elseif (in_array($key, $passwordVars)) {
            return 'password';
        } elseif (in_array($key, $urlVars)) {
            return 'url';
        } elseif (in_array($key, $emailVars)) {
            return 'email';
        }
        
        return 'text';
    }
}
