<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class GeoLocationRateLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        RateLimiter::for('geo-location', function () use ($request) {
            return Limit::perMinute(10)->by(optional($request->user())->id ?: $request->ip());
        });

        $key = 'geo-location|' . (optional($request->user())->id ?: $request->ip());
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }

        RateLimiter::hit($key);

        return $next($request);
    }
}
