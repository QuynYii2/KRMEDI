<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            if (!Auth::check()) {
                $user = JWTAuth::parseToken()->authenticate();
            } else {
                $user = Auth::user();
            }

            $expiresAt = now()->addMinutes(2); /* keep online for 2 min */
            Cache::put('user-is-online|' . $user->id, true, $expiresAt);

            /* last seen */
            User::where('id', $user->id)->update(['last_seen' => now()]);
        } catch (Exception $e) {
        }

        return $next($request);

    }
}
