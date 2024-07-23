<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterUser;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Countries;
use App\Models\States;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\MasterProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProfilesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth_master');
    }
    
    public function edit(Request $request): View
    {
        $countries = Countries::all();
        $user = Auth::guard('masteradmins')->user();
        $states = States::where('country_id', $user->country_id)->get();
        // dd($user);
        return view('masteradmin.profile.edit', [
            'user' => $user,
            'countries' => $countries,
            'states' => $states,
            'selectedStateId' => $user->state_id 
        ]);
    }

    public function getStates($countryId): JsonResponse
    {
        $states = States::where('country_id', $countryId)->get();

        return response()->json($states);
    }

    public function update(MasterProfileUpdateRequest $request): RedirectResponse
    {
        // dd('giiii');
        // exit;
        $user = Auth::guard('masteradmins')->user();
        $user->fill($request->validated());
        
        // Handle the image upload
        $user->user_image = $this->handleImageUpload($request, $user->user_image, 'masteradmin/profile_image');

        $user->save();

        return Redirect::route('business.profile.edit')->with('status', 'profile-updated');
    }
    

}
