<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUserDetails;
use Illuminate\Support\Facades\View;
use App\Models\UserRole;
use App\Models\MasterUserAccess;
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

        // Retrieve user details from session
        $userDetailsFromSession = session('user_details');
        if ($userDetailsFromSession) {

            $userDetailsModel = new MasterUserDetails();
            
            $userDetailsModel->setTableForUniqueId($userDetailsFromSession['user_id']);
            // dd($userDetailsModel);
            $user = $userDetailsModel->where('users_id', $userDetailsFromSession['users_id'])->first();
            // dd($user);
            if ($user) {
                Auth::guard($guard)->login($user);

                // dd($userDetails);
                if (Auth::guard($guard)->check()) {
                    $user = Auth::guard($guard)->user();
                
                    $userDetails = new MasterUserDetails();
                    $userDetails->setTableForUniqueId($user->user_id);

                    $existingUser = $userDetails->where('users_id', $user->users_id)->first();
                    if ($existingUser) {
                        $userRole = new UserRole();
                        $userRole->setTable($user->user_id . '_py_users_role');

                        $role = $userRole->where('role_id', $existingUser->role_id)->first();
                    
                        if ($role) {
                            $userRoleAccess = new MasterUserAccess();
                            $userRoleAccess->setTable($user->user_id . '_py_master_user_access');
                        
                            $userAccess = $userRoleAccess->where('role_id', $role->role_id)->get();
                            // dd($userAccess);
                            if ($userAccess) {
                                $access = $userAccess->pluck('is_access', 'mname')->toArray();
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
                } else {
                    View::share('user_access', []);
                }
            }
        }
        return $next($request);
    }


}