<?php

namespace App\Http\Controllers\superadmin;

// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\View\View;
use App\Models\MasterUser;
use App\Models\MasterUserDetails;
use DB;
use App\Http\Controllers\Controller;

class BusinessDetailController extends Controller
{
    public function index(): View
    {
        $MasterUser = MasterUser::with('plan')->get();

        $MasterUser->each(function ($user) {
            $userDetails = new MasterUserDetails();
            $userDetails->setTableForUniqueId($user->buss_unique_id);
            $totalUserCount = $userDetails->where('users_email', '!=', $user->user_email)->count();
            $user->totalUserCount = $totalUserCount;

        });
        // dd($MasterUser);
        return view('superadmin.businessdetails.index')->with('MasterUser', $MasterUser);
    }
    public function show($id)
    {
        $user = MasterUser::findOrFail($id);

        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($user->buss_unique_id);

        $udetail = $userDetails->where('users_email', '!=', $user->user_email)->get();
        $totalUserCount = $userDetails->where('users_email', '!=', $user->user_email)->count();
        $user->totalUserCount = $totalUserCount;

        $tableName = $user->buss_unique_id . '_py_users_role';

        foreach ($udetail as $detail) {
            $role = DB::table($tableName)->where('role_id', $detail->role_id)->first();
            $detail->role_name = $role ? $role->role_name : 'No Role Assigned';
        }

        return view('superadmin.businessdetails.view_business', compact('user', 'udetail'));
    }

}
