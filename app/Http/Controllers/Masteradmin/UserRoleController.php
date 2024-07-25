<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    //
    public function index(): View
    {
        $roles = UserRole::where('role_status', 1)->get();
        return view('masteradmin.role.index', compact('roles'));
    }

    public function create(): View
    {
        return view('masteradmin.role.add');
    }

    
}
