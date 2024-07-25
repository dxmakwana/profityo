<?php

namespace App\Http\Controllers\Auth\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUser;

class MasterPasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
       // Validate the request
    $validated = $request->validateWithBag('updatePassword', [
        'current_password' => ['required', 'string', 'max:255'],
        'user_password' => ['required', 'string', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
    ],[
        'user_password.required' => 'The Password field is required.',
    ]);

    // Get the authenticated user
    $user = Auth::guard('masteradmins')->user();

    // Verify the current password
    if (!Hash::check($request->current_password, $user->user_password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Hash and update the new password
    $user->user_password = Hash::make($request->user_password);
    $user->save();
    \LogActivity::addToLog('Master Admin Password changed is Updated.');
    // Redirect back with status message
    return back()->with('status', 'password-updated');
    }
}
