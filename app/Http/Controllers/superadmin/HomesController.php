<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $user = Auth::guard('web')->user();
      
        if (!$user) {
            return redirect()->route('login'); // Handle unauthenticated cases
        }

        return view('auth.dashboard');
    }

}
