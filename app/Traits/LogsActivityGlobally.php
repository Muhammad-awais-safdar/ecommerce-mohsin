<?php

namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

trait LogsActivityGlobally
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log all attributes
            ->logOnlyDirty() // Only log changes
            ->useLogName(class_basename($this)) // e.g., "Product", "Order"
            ->setDescriptionForEvent(fn(string $eventName) => $eventName);
    }

    public function tapActivity($activity, string $eventName)
    {
        $properties = $activity->properties->toArray();
        
        // Add additional context information
        $properties['ip_address'] = request()->ip();
        $properties['user_agent'] = request()->userAgent();
        $properties['url'] = request()->fullUrl();
        $properties['method'] = request()->method();
        $properties['timestamp'] = now()->toISOString();
        
        // Add user context if available
        if (\Illuminate\Support\Facades\Auth::check()) {
            $properties['user_context'] = [
                'id' => \Illuminate\Support\Facades\Auth::id(),
                'name' => \Illuminate\Support\Facades\Auth::user()->name,
                'email' => \Illuminate\Support\Facades\Auth::user()->email,
            ];
        }
        
        // Add model context
        $properties['model_context'] = [
            'id' => $this->id ?? null,
            'table' => $this->getTable(),
            'primary_key' => $this->getKeyName(),
        ];
        
        $activity->properties = $properties;
    }
}
