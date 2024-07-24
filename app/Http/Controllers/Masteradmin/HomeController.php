<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function create()
    {
        $user = Auth::guard('masteradmins')->user();

        if (!$user) {
            return redirect()->route('business.login'); // Handle unauthenticated cases
        }

        $plan = $user->sp_id; // Assuming this correctly references the plan relationship

        if (!$plan) {
            session()->flash('showModal', 'Please purchase a plan first.');
        }elseif ($user->sp_expiry_date < now()) {
            session()->flash('showModal', 'Your plan has expired. Please purchase a new plan.');
        }

        return view('masteradmin.auth.home');
    }

}
