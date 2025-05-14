<?php

namespace App\Listeners;

use App\Events\LoginActivityLogged;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use App\Models\LoginActivity;

class LogLoginActivity
{
    public function handle(LoginActivityLogged $event): void
    {
        $user = $event->user;
        $request = $event->request;

        $ip = $request->ip();
        $location = Location::get($ip);
        $agent = new Agent();

        $sessionHash = md5($ip . $request->userAgent());

        // Check if this session was already logged
        if (!LoginActivity::where('user_id', $user->id)->where('session_hash', $sessionHash)->exists()) {
            LoginActivity::create([
                'user_id'     => $user->id,
                'ip_address'  => $ip,
                'location'    => $location ? "{$location->city}, {$location->regionName}, {$location->countryName}" : 'Unknown',
                'isp'         => $location->isp ?? 'Unknown',
                'platform'    => $agent->platform(),
                'device_type' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
                'browser'     => $agent->browser(),
                'user_agent'  => $request->userAgent(),
                'session_hash' => $sessionHash,
                'is_notified' => false,
            ]);
        }
    }
}
