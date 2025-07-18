<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Activitylog\Facades\LogActivity;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Only log certain routes and successful requests
        if ($this->shouldLog($request, $response)) {
            $this->logActivity($request, $response);
        }
        
        return $response;
    }
    
    private function shouldLog(Request $request, $response): bool
    {
        // Don't log if response is not successful
        if (!$response->isSuccessful()) {
            return false;
        }
        
        // Don't log asset requests
        if ($request->is('css/*', 'js/*', 'images/*', 'storage/*', 'assets/*')) {
            return false;
        }
        
        // Don't log API requests for now
        if ($request->is('api/*')) {
            return false;
        }
        
        // Don't log livewire requests
        if ($request->is('livewire/*')) {
            return false;
        }
        
        // Only log important routes
        return $request->is(
            'admin/*',
            'shop',
            'product/*',
            'cart/*',
            'checkout/*'
        );
    }
    
    private function logActivity(Request $request, $response)
    {
        $action = $this->getAction($request);
        
        if ($action) {
            LogActivity::performedOn(new \stdClass())
                ->causedBy(auth()->user())
                ->withProperties([
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'route_name' => $request->route()?->getName(),
                    'parameters' => $request->route()?->parameters(),
                    'timestamp' => now()->toISOString(),
                ])
                ->log($action);
        }
    }
    
    private function getAction(Request $request): ?string
    {
        $route = $request->route();
        
        if (!$route) {
            return null;
        }
        
        $routeName = $route->getName();
        $method = $request->method();
        $uri = $request->path();
        
        // Map routes to user-friendly actions
        if ($routeName === 'shop') {
            return 'Viewed shop page';
        }
        
        if ($routeName === 'product.show') {
            return 'Viewed product: ' . ($route->parameter('slug') ?? 'unknown');
        }
        
        if (str_contains($uri, 'admin')) {
            return 'Accessed admin panel: ' . $uri;
        }
        
        if (str_contains($uri, 'cart')) {
            return match ($method) {
                'POST' => 'Added item to cart',
                'PUT', 'PATCH' => 'Updated cart',
                'DELETE' => 'Removed item from cart',
                default => 'Accessed cart'
            };
        }
        
        if (str_contains($uri, 'checkout')) {
            return 'Accessed checkout';
        }
        
        return null;
    }
}