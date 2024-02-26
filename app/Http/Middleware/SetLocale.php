<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('locale');
        if (!$locale){
            $locale = 'vi';
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
