<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $user = JWTAuth::parseToken()->authenticate();
            }
            $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
            if (!$role_user) {
                User::where('id', $user->id)->delete();
                Auth::logout();
                return redirect(route('home'));
            }
            $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

            if ($roleNames->contains('ADMIN')) {
                return $next($request);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response('Token is Expired', 444);
            } else {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return response('Forbidden: You don’t have permission to access [directory] on this server', 403);
    }
}
