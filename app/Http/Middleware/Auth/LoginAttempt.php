<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class LoginAttempt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (RateLimiter::tooManyAttempts('send-message:' . $request->login, $perMinute = 5)) {
            $seconds = RateLimiter::availableIn('send-message:' . $request->login);
            $timeString = sprintf('%dm %ds', floor(($seconds % 3600) / 60), $seconds % 60);
            return response()->json([
                'status' => false,
                'message' => 'You may try again in ' . $timeString,
            ], 429);
        }
        RateLimiter::hit('send-message:' . $request->login, 300);
        return $next($request);
    }
}
