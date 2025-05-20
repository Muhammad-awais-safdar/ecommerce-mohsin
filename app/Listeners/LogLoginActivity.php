<?php

namespace App\Listeners;

use App\Events\LoginActivityLogged;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use App\Models\LoginActivity;

class LogLoginActivity
{
    /**
     * Handle the event.
     */
    public function handle(LoginActivityLogged $event): void
    {
        $user = $event->user;
        $request = $event->request;

        // Handle localhost IP for testing
        $ip = $request->ip() === '127.0.0.1' ? '8.8.8.8' : $request->ip();

        // Get location info
        $location = Location::get($ip);

        // Set default values
        $city = $location->city ?? null;
        $region = $location->regionName ?? null;
        $country = $location->countryName ?? null;
        $isp = $location->isp ?? 'Unknown';

        // Combine location info
        $locationString = 'Unknown';
        if ($city || $region || $country) {
            $locationParts = array_filter([$city, $region, $country]);
            $locationString = implode(', ', $locationParts);
        }

        // User Agent Details
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $sessionHash = md5($ip . $request->userAgent());

        // Check if this session is already logged
        if (!LoginActivity::where('user_id', $user->id)
            ->where('session_hash', $sessionHash)
            ->exists()) {

            LoginActivity::create([
                'user_id'     => $user->id,
                'ip_address'  => $ip,
                'location'    => $locationString,
                'isp'         => $isp,
                'platform'    => $agent->platform() ?? 'Unknown',
                'device_type' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
                'browser'     => $agent->browser() ?? 'Unknown',
                'user_agent'  => $request->userAgent(),
                'session_hash' => $sessionHash,
                'is_notified' => false,
            ]);
        }
    }
}
