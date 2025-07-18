<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Only add cache headers for GET requests
        if ($request->isMethod('GET')) {
            $response->headers->set('Cache-Control', 'public, max-age=1800'); // 30 minutes
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 1800) . ' GMT');
        }
        
        return $response;
    }
}