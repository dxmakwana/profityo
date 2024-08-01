<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUserDetails;
use Illuminate\Support\Facades\View;

class PlanAccessMiddleware
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
            
            // Initialize the MasterUserDetails model and set the table
            $userDetails = new MasterUserDetails();
            $userDetails->setTableForUniqueId($user->buss_unique_id);

            // Find the user's details
            $existingUser = $userDetails->where('user_id', $user->buss_unique_id)->first();
           
            if ($existingUser) {
                // Retrieve the MasterUser instance from MasterUserDetails
                $masterUser = $existingUser->masterUser;
                
                // Ensure masterUser is loaded
                if ($masterUser) {
                    // Load user access rights
                    $access = $masterUser->userAccess->pluck('is_access', 'mname')->toArray();
                    // dd($access);
                    View::share('access', $access);
                } else {
                    View::share('access', []);
                }
            } else {
                View::share('access', []);
            }
        } else {
            View::share('access', []);
        }

        return $next($request);
    }

}