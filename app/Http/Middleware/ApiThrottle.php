<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ApiThrottle extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|string  $maxAttempts
     * @param  float|int  $decayMinutes
     * @param  string  $prefix
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        // More restrictive for search endpoints
        if ($request->is('api/search*')) {
            $maxAttempts = 30; // 30 requests per minute for search
        }
        
        // Less restrictive for health check
        if ($request->is('api/health')) {
            $maxAttempts = 120; // 120 requests per minute for health check
        }

        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }
}
