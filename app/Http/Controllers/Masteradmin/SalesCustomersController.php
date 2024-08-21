<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\SalesCustomers;
use App\Models\Countries;
use App\Models\States;
use Illuminate\Http\JsonResponse;

class SalesCustomersController extends Controller
{
    //
    public function index(): View
    {
        //
        // dd('hii');
        $SalesCustomers = SalesCustomers::all();
        return view('masteradmin.customers.index')->with('SalesCustomers', $SalesCustomers);
    }
    public function customerStates($country_id)
    {

        // dd($country_id);
        $states = States::where('country_id', $country_id)->get();
        return response()->json($states);
    }
    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        $State = States::all(); // Fetch all states
        return view('masteradmin.customers.add', compact('Country', 'State'));
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        // Get the authenticated user
        $user = Auth::guard('masteradmins')->user();

        $request->validate([
            'sale_cus_business_name' => 'required|string|max:255',
            'sale_cus_first_name' => 'nullable|string|max:255',
            'sale_cus_last_name' => 'nullable|string|max:255',
            'sale_cus_email' => 'nullable|email|max:255',
            'sale_cus_phone' => 'nullable|numeric',
            'sale_cus_account_number' => 'nullable|numeric',
            'sale_cus_website' => 'nullable|string|max:255',
            'sale_cus_notes' => 'nullable|string|max:255',
            'sale_bill_address1' => 'nullable|string|max:255',
            'sale_bill_address2' => 'nullable|string|max:255',
            // 'sale_bill_country_id' => 'nullable|exists:Countries,id',
            'sale_bill_city_name' => 'nullable|string|max:255',
            'sale_bill_zipcode' => 'nullable|numeric',
            // 'sale_bill_state_id' => 'nullable|exists:states,id',
            // 'sale_ship_country_id' => 'nullable|exists:Countries,id',
            'sale_ship_shipto' => 'nullable|string|max:255',
            'sale_ship_address1' => 'nullable|string|max:255',
            'sale_ship_address2' => 'nullable|string|max:255',
            'sale_ship_city_name' => 'nullable|string|max:255',
            'sale_ship_zipcode' => 'nullable|numeric',
            // 'sale_ship_state_id' => 'nullable|exists:states,id',
            'sale_ship_phone' => 'nullable|numeric',
            'sale_ship_delivery_desc' => 'nullable|string|max:255',
            'sale_same_address' => 'nullable|boolean',
        ],[
            'sale_cus_business_name.required' => 'The name field is required.',
            'sale_cus_first_name.required' => 'The First name field is required.',
            'sale_cus_last_name.required' => 'The Last name field is required.',
            'sale_cus_phone.required' => 'The Phone number field is required.',
        ]);

        // Prepare the data for insertion
        $validatedData = $request->all();
        $validatedData['sale_same_address'] = $request->has('sale_same_address') ? 'on' : 'off';
        $validatedData['id'] = $user->id; // Use the correct field name for user ID
        $validatedData['sale_cus_status'] = 1;

        // Insert the data into the database
        SalesCustomers::create([
            'sale_cus_business_name' => $validatedData['sale_cus_business_name'],
            'sale_cus_first_name' => $validatedData['sale_cus_first_name'],
            'sale_cus_last_name' => $validatedData['sale_cus_last_name'],
            'sale_cus_email' => $validatedData['sale_cus_email'],
            'sale_cus_phone' => $validatedData['sale_cus_phone'],
            'sale_cus_account_number' => $validatedData['sale_cus_account_number'],
            'sale_cus_website' => $validatedData['sale_cus_website'],
            'sale_cus_notes' => $validatedData['sale_cus_notes'],
            'sale_bill_currency_id' => $validatedData['sale_bill_currency_id'],
            'sale_bill_address1' => $validatedData['sale_bill_address1'],
            'sale_bill_address2' => $validatedData['sale_bill_address2'],
            'sale_bill_country_id' => $validatedData['sale_bill_country_id'],
            'sale_bill_city_name' => $validatedData['sale_bill_city_name'],
            'sale_bill_zipcode' => $validatedData['sale_bill_zipcode'],
            'sale_bill_state_id' => $validatedData['sale_bill_state_id'],
            'sale_ship_country_id' => $validatedData['sale_ship_country_id'],
            'sale_ship_shipto' => $validatedData['sale_ship_shipto'],
            'sale_ship_address1' => $validatedData['sale_ship_address1'],
            'sale_ship_address2' => $validatedData['sale_ship_address2'],
            'sale_ship_city_name' => $validatedData['sale_ship_city_name'],
            'sale_ship_zipcode' => $validatedData['sale_ship_zipcode'],
            'sale_ship_state_id' => $validatedData['sale_ship_state_id'],
            'sale_ship_phone' => $validatedData['sale_ship_phone'],
            'sale_ship_delivery_desc' => $validatedData['sale_ship_delivery_desc'],
            'sale_same_address' => $validatedData['sale_same_address'],
            'id' => $validatedData['id'], // Use the correct field name for user ID
            'sale_cus_status' => $validatedData['sale_cus_status'],
        ]);

        return redirect()->route('business.salescustomers.index')->with(['sales-customers-add' => __('messages.masteradmin.sales-customers.send_success')]);
    }



    public function edit($sale_cus_id, Request $request): View
    {
        // \DB::enableQueryLog(); // Enable query log

        $SalesCustomerse = SalesCustomers::where('sale_cus_id', $sale_cus_id)->firstOrFail();
        // dd($SalesCustomerse->sale_bill_currency_id);
        $Country = Countries::all(); 
        $State = collect();
        if ($SalesCustomerse && $SalesCustomerse->sale_bill_country_id) {
            $State = States::where('country_id', $SalesCustomerse->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($SalesCustomerse && $SalesCustomerse->sale_ship_country_id) {
            $ship_state = States::where('country_id', $SalesCustomerse->sale_ship_country_id)->get();
        }

        // dd($State);
        // $State = States::all();
        // dd(\DB::getQueryLog()); // Show results of log
        return view('masteradmin.customers.edit', compact('SalesCustomerse','Country','State','ship_state'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sale_cus_id): RedirectResponse
    {
        // \DB::enableQueryLog(); // Enable query log

        // dd($request);
        $user = Auth::guard('masteradmins')->user();

        $SalesCustomersu = SalesCustomers::where(['sale_cus_id' => $sale_cus_id])->firstOrFail();
        // dd($SalesCustomersu);
        $validatedData = $request->validate([
            'sale_cus_business_name' => 'required|string|max:255',
            'sale_cus_first_name' => 'nullable|string|max:255',
            'sale_cus_last_name' => 'nullable|string|max:255',
            'sale_cus_email' => 'nullable|email|max:255',
            'sale_cus_phone' => 'nullable|numeric',
            'sale_cus_account_number' => 'nullable|numeric',
            'sale_cus_website' => 'nullable|string|max:255',
            'sale_cus_notes' => 'nullable|string|max:255',
            'sale_bill_currency_id' => 'nullable',
            'sale_bill_address1' => 'nullable|string|max:255',
            'sale_bill_address2' => 'nullable|string|max:255',
            'sale_bill_country_id' => 'nullable|numeric',
            'sale_bill_city_name' => 'nullable|string|max:255',
            'sale_bill_zipcode' => 'nullable|numeric',
            'sale_bill_state_id' => 'nullable|numeric',
            'sale_ship_country_id' => 'nullable|numeric',
            'sale_ship_shipto' => 'nullable|string|max:255',
            'sale_ship_address1' => 'nullable|string|max:255',
            'sale_ship_address2' => 'nullable|string|max:255',
            'sale_ship_city_name' => 'nullable|string|max:255',
            'sale_ship_zipcode' => 'nullable|numeric',
            'sale_ship_state_id' => 'nullable|numeric',
            'sale_ship_phone' => 'nullable|numeric',
            'sale_ship_delivery_desc' => 'nullable|string|max:255',
            'sale_same_address' => 'nullable|boolean',
        ]);
        

        // Handle checkboxes: if not checked, they won't be present in the request
    //     $validatedData = $request->all();
    // //  dd($validatedData);
        $validatedData['sale_same_address'] = $request->has('sale_same_address') ? 'on' : 'off';
    //     $validatedData['id'] = $user->id; // Use the correct field name for user ID
    //     $validatedData['sale_cus_status'] = 1;
     
        $SalesCustomersu->where('sale_cus_id', $sale_cus_id)->update($validatedData);
        
     
        return redirect()->route('business.salescustomers.edit', ['SalesCustomers' => $SalesCustomersu->sale_cus_id])
        ->with('sales-customers-edit', __('messages.masteradmin.sales-customers.edit_salescustomers_success'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sale_cus_id): RedirectResponse
    {
        //
        // $user = Auth::guard('masteradmins')->user();

        $SalesCustomers = SalesCustomers::where(['sale_cus_id' => $sale_cus_id])->firstOrFail();

        // Delete the SalesCustomers
        $SalesCustomers->where('sale_cus_id', $sale_cus_id)->delete();

        // \MasterLogActivity::addToLog('Admin SalesCustomers Deleted.');

        return redirect()->route('business.salescustomers.index')->with('sales-customers-delete', __('messages.masteradmin.sales-customers.delete_salescustomers_success'));

    }

    public function getCustomerInfo(Request $request)
    {
        $sale_cus_id = $request->query('sale_cus_id');
        // dd($sale_cus_id);
        $customer = SalesCustomers::where('sale_cus_id', $sale_cus_id)->first()->load('state', 'country');

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully',
            'data' => $customer
        ]);
    }

    public function getStates($countryId): JsonResponse
    {
        $states = States::where('country_id', $countryId)->get();

        return response()->json($states);
    }
}
