<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Estimates;
use App\Models\BusinessDetails;
use App\Models\Countries;
use App\Models\States;

class EstimatesController extends Controller
{
    //
    public function index(): View
    {
        //
        // dd('hii');
        // $SalesCustomers = Estimates::all();
        return view('masteradmin.estimates.index');
    }
    public function create(): View
    {
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $countries = Countries::all();
        $states = collect();
        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        if ($businessDetails && $businessDetails->country_id) {
            $states = States::where('country_id', $businessDetails->country_id)->get();
        }
        // dd($businessDetails);
        return view('masteradmin.estimates.add', compact('businessDetails','countries','states','currency'));
    }
}
