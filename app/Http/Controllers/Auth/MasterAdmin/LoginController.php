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
use App\Http\Requests\Auth\Masteradmin\MasterLoginRequest;


class LoginController extends Controller
{
    public function create(): View
    {
        // dd('hiii');
        return view('masteradmin.auth.login');
    }

    public function store(MasterLoginRequest $request): RedirectResponse
    {
        dd($request);
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

}
