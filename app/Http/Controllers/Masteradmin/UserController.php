<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterUserDetails;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index(): View
    {
        //
        // dd('hii');
        $userdetail = MasterUserDetails::all();
        // dd($userdetail);
        return view('masteradmin.userdetails.index')->with('userdetail', $userdetail);
    }
    public function create(): View
{
    $roles = UserRole::all(); // Fetch all roles from the user_role table
    return view('masteradmin.userdetails.add', compact('roles'));
}
    
    public function store(Request $request)
    {
        $user = Auth::guard('masteradmins')->user();

        $validatedData = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|string|max:255',
            'users_phone' => 'required|string',
            'users_password' => 'nullable|string',
            'role_id' => 'required|string',
        ], [
            'users_name.required' => 'The name field is required.',
            'users_email.required' => 'The email field is required.',
            'users_phone.required' => 'The phone field is required.',
            'users_password.required' => 'The password field is required.',
        ]);
        
        // Fetch the role from the user_role table using the role_id
        $role = UserRole::find($validatedData['role_id']);
        if (!$role) {
            return redirect()->back()->withErrors(['role_id' => 'Invalid role ID.']);
        }
        if (!empty($validatedData['users_password'])) {
            $validatedData['users_password'] = Hash::make($validatedData['users_password']);
        }
        $validatedData['id'] = $user->id;
        $validatedData['users_status'] = 1;
        MasterUserDetails::create($validatedData);
    
        return redirect()->route('business.userdetail.index')->with(['user-add' => __('messages.masteradmin.user.send_success')]);
    }
    



    public function edit($users_id, Request $request): View
    {
        $userdetaile = MasterUserDetails::where('users_id', $users_id)->firstOrFail();
        $roles = UserRole::all(); // Fetch roles here

        return view('masteradmin.userdetails.edit', compact('userdetaile','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $users_id): RedirectResponse
    {
        $user = Auth::guard('masteradmins')->user();

        $userdetailu = MasterUserDetails::where(['users_id' => $users_id,'id' => $user->id])->firstOrFail();

        // Log request data
        Log::info('Update request data:', $request->all());

        $validatedData = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|string|max:255',
            'users_phone' => 'required|string',
            'users_password' => 'nullable|string',
            'role_id' => 'required|string',
        ], [
            'users_name.required' => 'The name field is required.',
            'users_email.required' => 'The email field is required.',
            'users_phone.required' => 'The phone field is required.',
            'users_password.required' => 'The password field is required.',
        ]);

        $role = UserRole::find($validatedData['role_id']);
        if (!$role) {
            return redirect()->back()->withErrors(['role_id' => 'Invalid role ID.']);
        }

        if (!empty($validatedData['users_password'])) {
            $validatedData['users_password'] = Hash::make($validatedData['users_password']);
        }

        
        $userdetailu->where('users_id', $users_id)->update($validatedData);
        
        // Redirect back to the edit form with a success message
        return redirect()->route('business.userdetail.edit', ['userdetaile' => $userdetailu->users_id])->with('user-edit', __('messages.masteradmin.user.edit_user_success'));
    }


    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy($users_id): RedirectResponse
    {
        //
        $user = Auth::guard('masteradmins')->user();

        $userdetail = MasterUserDetails::where(['users_id' => $users_id, 'id' => $user->id])->firstOrFail();

        // Delete the userdetail
        $userdetail->where('users_id', $users_id)->delete();

        // \LogActivity::addToLog('Admin userdetail Deleted.');

        return redirect()->route('business.userdetail.index')->with('user-delete', __('messages.masteradmin.user.delete_user_success'));

    }
    
}
