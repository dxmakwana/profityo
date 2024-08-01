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
        // Get the authenticated user
        $user = Auth::guard('masteradmins')->user();

        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($user->user_id);

        $userdetail = $userDetails->get();
        
        $userdetail->each(function($detail) {
            $detail->load('userRole');
        });
        
        // dd($userdetail);

        return view('masteradmin.userdetails.index')->with('userdetail', $userdetail);

    }
    public function create(): View
    {
        $roles = UserRole::all(); 
        return view('masteradmin.userdetails.add', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::guard('masteradmins')->user();

        $validatedData = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|string|max:255',
            'users_phone' => 'required|string',
            'users_password' => 'required|string',
            'role_id' => 'required|integer',
        ], [
            'users_name.required' => 'The name field is required.',
            'users_email.required' => 'The email field is required.',
            'users_phone.required' => 'The phone field is required.',
            'users_password.required' => 'The password field is required.',
            'role_id.required' => 'The role field is required.',
            'role_id.integer' => 'The role field is required.',
        ]);
        
        
        if (!empty($validatedData['users_password'])) {
            $validatedData['users_password'] = Hash::make($validatedData['users_password']);
        }
        $validatedData['id'] = $user->id;
        $validatedData['users_status'] = 1;
        $validatedData['users_image'] = '';
        $validatedData['country_id'] = 0;
        $validatedData['state_id'] = 0;
        $validatedData['users_city_name'] = '';
        $validatedData['users_pincode'] = '';

        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($user->user_id);
      
        $userDetails->create($validatedData);

        \MasterLogActivity::addToLog('Admin userdetail Created.');
    
        return redirect()->route('business.userdetail.index')->with(['user-add' => __('messages.masteradmin.user.send_success')]);
    }
    

    public function edit($users_id, Request $request): View
    {
       
        $user = Auth::guard('masteradmins')->user();
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($user->user_id);

        $userdetaile = $masteruser->where('users_id', $users_id)->firstOrFail();
        $roles = UserRole::all(); 

        return view('masteradmin.userdetails.edit', compact('userdetaile', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $users_id): RedirectResponse
    {
        $user = Auth::guard('masteradmins')->user();
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($user->user_id);
      
        $userdetailu = $masteruser->where(['users_id' => $users_id,'id' => $user->id])->firstOrFail();

        $validatedData = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|string|max:255',
            'users_phone' => 'required|string',
            'users_password' => 'nullable|string',
            'role_id' => 'required|integer',
        ], [
            'users_name.required' => 'The name field is required.',
            'users_email.required' => 'The email field is required.',
            'users_phone.required' => 'The phone field is required.',
            'users_password.required' => 'The password field is required.',
            'role_id.required' => 'The role field is required.',
            'role_id.integer' => 'The role field is required.',
        ]);

       
        if (!empty($validatedData['users_password'])) {
            $validatedData['users_password'] = Hash::make($validatedData['users_password']);
        }

    
        $userdetailu->where('users_id', $users_id)->update($validatedData);
        
        \MasterLogActivity::addToLog('Admin userdetail Edited.');

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
        \MasterLogActivity::addToLog('Admin userdetail Deleted.');
        // \LogActivity::addToLog('Admin userdetail Deleted.');

        return redirect()->route('business.userdetail.index')->with('user-delete', __('messages.masteradmin.user.delete_user_success'));

    }
    
}
