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
use App\Models\BusinessDetails;

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
        \LogActivity::addToLog('Master Admin Profile is Edited.');
        return Redirect::route('business.profile.edit')->with('status', 'profile-updated');
    }

    public function businessProfile(Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        $BusinessDetails = BusinessDetails::where('id', $user->id)->where('bus_status', 1)->first();
        // dd($BusinessDetails);
        $countries = Countries::all();
        $states = collect();
        $currency = Countries::where('id', $BusinessDetails->bus_currency)->first();

        if ($BusinessDetails && $BusinessDetails->country_id) {
            $states = States::where('country_id', $BusinessDetails->country_id)->get();
        }
        
        // dd($user);
        return view('masteradmin.profile.business-profile', [
            'BusinessDetails' => $BusinessDetails,
            'user' => $user,
            'countries' => $countries,
            'states' => $states,
            'currency' => $currency
        ]);
    }
    
    public function businessProfileUpdate(Request $request): RedirectResponse
    {
        $user = Auth::guard('masteradmins')->user();
        $BusinessDetails = BusinessDetails::where('id', $user->id)->where('bus_status', 1)->first();

        $validatedData = $request->validate([
            'bus_company_name' => 'required|string|max:255',
            'bus_address1' => 'required|string|max:255',
            'bus_address2' => 'required|string|max:255',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_name' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'bus_phone' => 'required|string|max:15',
            'bus_mobile' => 'nullable|string|max:15',
            'bus_website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'bus_company_name.required' => 'The Company name field is required.',
            'bus_address1.required' => 'The address1 field is required.',
            'bus_address2.required' => 'The address2 field is required.',
            'country_id.required' => 'The country field is required',
            'state_id.required' => 'The state field is required',
            'city_name.required' => 'The city name field is required',
            'zipcode.required' => 'The zipcode field is required',
            'bus_phone.required' => 'The phone field is required.',
            'bus_mobile.string' => 'The mobile field is required.',
            'bus_website.string' => 'The website field is required.',
            'image.image' => 'The image field is required.',
        ]);

        $imageFilename = $this->handleImageUpload($request, $BusinessDetails->bus_image ?? null, 'masteradmin/business_profile');
        $currency_id = Countries::where('id', 233)->first();
        // dd($currency_id);

        if ($BusinessDetails) {
            // Update existing record
            $validatedData['bus_image'] = $imageFilename;
            $validatedData['bus_currency'] = $currency_id->id;
            $BusinessDetails->update($validatedData);
        } else {
            // Insert new record
            $validatedData['id'] = $user->id;
            $validatedData['bus_status'] = 1;
            $validatedData['bus_image'] = $imageFilename;
            $validatedData['bus_currency'] = $currency_id->id;
            BusinessDetails::create($validatedData);
        }
        \LogActivity::addToLog('Master Admin Business Profile is Edited.');

        return redirect()->route('business.business.edit')->with('business-update', __('messages.masteradmin.business-profile.send_success'));
    }

    public function logActivity()
    {
        $user = Auth::guard('masteradmins')->user();
        if($user)
        {
            $admin_user = MasterUser::where('user_id','=',$user->id);
            
            $logs = \MasterLogActivity::logActivityLists();
            
                return view('masteradmin.logs.index')
                                            ->with('admin_user',$admin_user)
                                            ->with('logs',$logs);
        }
    }

}
