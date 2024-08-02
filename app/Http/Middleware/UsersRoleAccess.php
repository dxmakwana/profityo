<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUserDetails;
use Illuminate\Support\Facades\View;

class UsersRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = 'masteradmins';

        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            dd($user);
            $userDetails = new MasterUserDetails();
            $userDetails->setTableForUniqueId($user->buss_unique_id);

            $existingUser = $userDetails->where('user_id', $user->buss_unique_id)->first();
           
            if ($existingUser) {
                $masterUser = $existingUser->masterUser;
                // dd($masterUser);
                if ($masterUser) {
                    $access = $masterUser->userAccess->pluck('is_access', 'mname')->toArray();
                    // dd($access);
                    View::share('user_access', $access);
                } else {
                    View::share('user_access', []);
                }
            } else {
                View::share('user_access', []);
            }
        } else {
            View::share('user_access', []);
        }

        return $next($request);
    }

}