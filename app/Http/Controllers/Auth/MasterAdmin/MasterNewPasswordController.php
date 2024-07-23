<?php

namespace App\Http\Controllers\Auth\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DB;
use App\Models\MasterUser;

class MasterNewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        // dd($request);
        return view('masteradmin.auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request);
        $request->validate([
            'token' => ['required'],
            'user_email' => ['required', 'email'],
            'user_password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'user_email.required' => 'The Email field is required.',
            'user_email.email' => 'The Email must be a valid email address.',
            'user_password.required' => 'The Password field is required.',
            'password_confirmation.required' => 'The confirmation Password field is required.',
        ]);
        
       
            $updatePassword = DB::table('master_password_reset_tokens')
                                ->where([
                                'email' => $request->user_email, 
                                'token' => $request->token
                                ])
                                ->first();
                                // dd(\DB::getQueryLog());

            if(!$updatePassword){
                return back()->with(['forgotpassword-error' =>__('messages.masteradmin.forgot-password.send_error')]);
            }
            $user = MasterUser::where('user_email', $request->user_email)
            ->update(['user_password' => Hash::make($request->user_password)]);

            DB::table('master_password_reset_tokens')->where(['email'=> $request->user_email])->delete();
           
            return redirect()->route('business.login')->with(['forgotpassword-success' =>__('messages.masteradmin.forgot-password.send_success')]);
            
    }
}