<?php

namespace App\Http\Controllers\Auth\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\MasterUser;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use App\Models\Plan;

class RegisterController extends Controller
{
    //
    public function create(): View
    {     
        return view('masteradmin.auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_first_name' => ['required', 'string', 'max:255'],
            'user_last_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['required', 'string', 'max:255'],
            'user_business_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.MasterUser::class],
            'user_password' => ['required', 'string', '', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ],[
            'user_first_name.required' => 'The First Name field is required.',
            'user_last_name.required' => 'The Last Name field is required.',
            'user_phone.required' => 'The Phone field is required.',
            'user_business_name.required' => 'The Business Name field is required.',
            'user_email.required' => 'The Email field is required.',
            'user_email.email' => 'The Email must be a valid email address.',
            'user_email.unique' => 'The Email has already been taken.',
            'user_password.required' => 'The Password field is required.',
        ]);
    
    
        // Generate unique buss_unique_id
        $buss_unique_id = $this->generateUniqueId(trim($request->user_business_name));

        $plan = Plan::where('sp_id', '12')->firstOrFail();

        $startDate = Carbon::now();

        $months = $plan->sp_month;
        $expirationDate = $startDate->addMonths($months);
        $expiryDate = $expirationDate->toDateString();

        $admin = MasterUser::create([
            'user_first_name' => $request->user_first_name,
            'user_last_name' => $request->user_last_name,
            'user_email' => $request->user_email,
            'user_phone' => $request->user_phone,
            'user_image' => '',
            'user_business_name' => $request->user_business_name,
            'buss_unique_id' => $buss_unique_id,
            'sp_id' => $request->sp_id,
            'user_password' => Hash::make($request->user_password),
            'sp_expiry_date' => $expiryDate,
            'isActive' => 1,
            'user_status' => 1
        ]);
    
        Auth::guard('masteradmins')->login($admin);
    
        return redirect(RouteServiceProvider::MASTER_HOME);
    }
    
    private function generateUniqueId(string $user_business_name): string
    {
        // Remove any whitespace from the user business name
        $cleaned_name = preg_replace('/\s+/', '', $user_business_name);

        // Generate the prefix from the cleaned name
        $prefix = strtolower(substr($cleaned_name, 0, 4));

        // Calculate the next number for the unique ID
        $number = MasterUser::where('buss_unique_id', 'LIKE', "{$prefix}%")->count() + 1;

        // Return the generated unique ID
        return $prefix . sprintf("%02d", $number);
    }
}
