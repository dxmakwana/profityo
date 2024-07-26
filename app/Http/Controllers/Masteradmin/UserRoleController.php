<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    //
    public function index(): View
    {
        $user = Auth::guard('masteradmins')->user();
        $roles = UserRole::where(['role_status' => 1, 'id' => $user->id])->get();
        return view('masteradmin.role.index', compact('roles'));
    }

    public function create(): View
    {
        return view('masteradmin.role.add');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::guard('masteradmins')->user();
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ], [
            'role_name.required' => 'The role name field is required.',
        ]);

        $validatedData['id'] = $user->id;
        $validatedData['role_status'] = 1;
        UserRole::create($validatedData);
        \LogActivity::addToLog('Master Admin Users Role Created.');

        return redirect()->route('business.role.index')->with(['role-add' =>__('messages.masteradmin.user-role.add_role_success')]);
    }

    public function edit($role_id, Request $request): View
    {   
        $user = Auth::guard('masteradmins')->user();
        $role = UserRole::where(['role_id' => $role_id , 'id' => $user->id])->firstOrFail();

        return view('masteradmin.role.edit', compact('role'));
    }

    public function update(Request $request, $role_id): RedirectResponse
    {   
        // Find the plan by sp_id
        $user = Auth::guard('masteradmins')->user();
        $roles = UserRole::where(['role_id' => $role_id, 'id' => $user->id])->firstOrFail();

        // Validate incoming request data
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ], [
            'role_name.required' => 'The role name field is required.',
        ]);

        // Update the plan attributes based on validated data
        $roles->where('role_id', $role_id)->update($validatedData);
        \LogActivity::addToLog('Master Admin User Role is Edited.');

        // Redirect back to the edit form with a success message
        return redirect()->route('business.role.edit', ['role' => $roles->role_id])
                        ->with('role-edit', __('messages.masteradmin.user-role.edit_role_success'));

    }

    public function destroy($role_id): RedirectResponse
    {
        //
        // dd($role_id);
        $user = Auth::guard('masteradmins')->user();
        $roles = UserRole::where(['role_id' => $role_id, 'id' => $user->id])->firstOrFail();

        // Delete the plan
        $roles->where('role_id', $role_id)->delete();

        \LogActivity::addToLog('Master Admin User role is Deleted.');
         
        return redirect()->route('business.role.index')
                        ->with('role-delete', __('messages.masteradmin.user-role.delete_role_success'));

    }


    

    
}
