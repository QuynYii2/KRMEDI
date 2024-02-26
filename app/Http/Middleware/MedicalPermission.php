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

class MedicalPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if ($this->isMedicalPermission()) {
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

    public function isMedicalPermission()
    {
        if (!Auth::check()) {
            $user = JWTAuth::parseToken()->authenticate();
        } else {
            $user = Auth::user();
        }
        $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
        if (!$role_user) {
            User::where('id', $user->id)->delete();
            Auth::logout();
            return redirect(route('home'));
        }
        $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

        if ($roleNames->contains('DOCTORS')
            || $roleNames->contains('PHAMACISTS')
            || $roleNames->contains('THERAPISTS')
            || $roleNames->contains('ESTHETICIANS')
            || $roleNames->contains('NURSES')
            || $roleNames->contains('PHARMACEUTICAL COMPANIES')
            || $roleNames->contains('HOSPITALS')
            || $roleNames->contains('CLINICS')
            || $roleNames->contains('PHARMACIES')
            || $roleNames->contains('SPAS')
            || $roleNames->contains('OTHERS')
            || $roleNames->contains('ADMIN')) {
            return true;
        }

        return false;
    }
}
