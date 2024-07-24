<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class PlanAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('masteradmins')->check()) {
            $user = Auth::guard('masteradmins')->user();
            $access = $user->userAccess->pluck('is_access', 'mname')->toArray();
            view()->share('access', $access);
        }

        return $next($request);
    }
}