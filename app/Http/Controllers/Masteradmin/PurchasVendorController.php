<?php

namespace App\Http\Controllers\Masteradmin;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchasVendor;
use App\Models\Countries;
use App\Models\States;
use App\Models\PurchasVendorBankDetail;



class PurchasVendorController extends Controller
{
    //
    public function index(): View
    {
        $PurchasVendor = PurchasVendor::with('tax','bankDetails')->get();
        return view('masteradmin.vendor.index')->with('PurchasVendor', $PurchasVendor);
    }

    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        $States = States::all();

        // // Fetch ChartAccount records based on type_id
        // $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        // $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.vendor.add', compact('Country', 'States'));
    }
    public function vendorStates($country_id)
    {

        // dd($country_id);
        $states = States::where('country_id', $country_id)->get();
        return response()->json($states);
    }
   
    public function store(Request $request)
{
    $user = Auth::guard('masteradmins')->user();
    
    // Validate the incoming request
    $request->validate([
        'purchases_vendor_name' => 'required|string|max:255',
        'purchases_vendor_first_name' => 'nullable|string|max:255',
        'purchases_vendor_last_name' => 'nullable|string|max:255',
        'purchases_vendor_email' => 'nullable|string|max:255',
        'purchases_vendor_country_id' => 'nullable|string|max:255',
        'purchases_vendor_security_number'=> 'nullable|string|max:255',
        'purchases_vendor_state_id' => 'nullable|string|max:255',
        'purchases_vendor_address1' => 'nullable|string|max:255',
        'purchases_vendor_address2' => 'nullable|string|max:255',
        'purchases_vendor_city_name' => 'nullable|string|max:255',
        'purchases_vendor_zipcode' => 'nullable|string|max:255',
        'purchases_vendor_account_number' => 'nullable|string|max:255',
        'purchases_vendor_phone' => 'nullable|string|max:255',
        'purchases_vendor_mobile' => 'nullable|string|max:255',
        'purchases_vendor_website' => 'nullable|string|max:255',
        'purchases_vendor_currency_id' => 'nullable|string|max:255',
        'type' => 'required|string|in:Vendor,1099-NEC Contractor',
    ], [
        'purchases_vendor_name.required' => 'The name field is required.',
        'type.required' => 'The vendor type field is required.',
        // 'type.in' => 'The selected vendor type is invalid.',
    ]);

    // Capture the selected radio button value
    $type = $request->input('type'); // This will be either 'Regular' or '1099-NEC Contractor'
   
    // Prepare the data for insertion
    $validatedData = $request->all();
    $validatedData['purchases_vendor_type'] = $type; // Store the value directly in the 'purchases_vendor_type' column
    $validatedData['id'] = $user->id;
    $validatedData['purchases_vendor_status'] = 1;
    
    // Insert the data into the database
    PurchasVendor::create([
        'purchases_vendor_name' => $validatedData['purchases_vendor_name'],
        'purchases_vendor_first_name' => $validatedData['purchases_vendor_first_name'],
        'purchases_vendor_last_name' => $validatedData['purchases_vendor_last_name'],
        'purchases_vendor_email' => $validatedData['purchases_vendor_email'],
        'purchases_vendor_country_id' => $validatedData['purchases_vendor_country_id'],
        'purchases_vendor_currency_id' => $validatedData['purchases_vendor_currency_id'],
        'purchases_vendor_state_id' => $validatedData['purchases_vendor_state_id'],
        'purchases_vendor_type' => $validatedData['purchases_vendor_type'], // Store directly
        'purchases_contractor_type' => $validatedData['purchases_contractor_type'],
        'purchases_vendor_security_number' => $validatedData['purchases_vendor_security_number'],
        'purchases_vendor_address1' => $validatedData['purchases_vendor_address1'],
        'purchases_vendor_address2' => $validatedData['purchases_vendor_address2'],
        'purchases_vendor_city_name' => $validatedData['purchases_vendor_city_name'],
        'purchases_vendor_zipcode' => $validatedData['purchases_vendor_zipcode'],
        'purchases_vendor_account_number' => $validatedData['purchases_vendor_account_number'],
        'purchases_vendor_phone' => $validatedData['purchases_vendor_phone'],
        'purchases_vendor_mobile' => $validatedData['purchases_vendor_mobile'],
        'purchases_vendor_website' => $validatedData['purchases_vendor_website'],
        'id' => $validatedData['id'],
        'purchases_vendor_status' => 1,
    ]);

    return redirect()->route('business.purchasvendor.index')->with(['purchases-vendor-add' => __('messages.masteradmin.purchases-vendor.send_success')]);
}



    public function edit($purchases_vendor_id, Request $request): View
    {
        $PurchasVendore = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();
        $Country = Countries::all(); // Fetch all countries
        $States = States::all();
        // Fetch ChartAccount records based on type_id
        // $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        // $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.vendor.edit', compact('PurchasVendore', 'Country', 'States'));
    }

    /**
     * Update the specified resource in storage.
     */
   
    public function update(Request $request, $purchases_vendor_id): RedirectResponse
{
    $PurchasVendoru = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();

    // Validate the incoming request
    $validatedData = $request->validate([
        'purchases_vendor_name' => 'required|string|max:255',
        'purchases_vendor_security_number' => 'nullable|string|max:255',
        'purchases_vendor_first_name' => 'nullable|string|max:255',
        'purchases_vendor_last_name' => 'nullable|string|max:255',
        'purchases_vendor_email' => 'nullable|string|max:255',
        'purchases_vendor_country_id' => 'nullable|string|max:255',
        'purchases_vendor_state_id' => 'nullable|string|max:255',
        'purchases_vendor_address1' => 'nullable|string|max:255',
        'purchases_vendor_address2' => 'nullable|string|max:255',
        'purchases_vendor_city_name' => 'nullable|string|max:255',
        'purchases_vendor_zipcode' => 'nullable|string|max:255',
        'purchases_vendor_account_number' => 'nullable|string|max:255',
        'purchases_vendor_phone' => 'nullable|string|max:255',
        'purchases_vendor_fax' => 'nullable|string|max:255',
        'purchases_vendor_mobile' => 'nullable|string|max:255',
        'purchases_vendor_toll_free' => 'nullable|string|max:255',
        'purchases_vendor_website' => 'nullable|string|max:255',
        'purchases_vendor_currency_id' => 'nullable|string|max:255',
        'purchases_contractor_type'=>'required|string|in:Individual,Business',
        'type' => 'required|string|in:Vendor,1099-NEC Contractor', // Add validation for type
    ]);

    // Capture the selected radio button value
    $type = $request->input('type'); 
    $purchases_contractor_type = $request->input('purchases_contractor_type');// This will be either 'Regular' or '1099-NEC Contractor'
    $validatedData['purchases_vendor_type'] = $type; // Store the value directly in the 'purchases_vendor_type' column
    $validatedData['purchases_contractor_type'] = $purchases_contractor_type; 
    // Update the vendor record with validated data
    $PurchasVendoru->where('purchases_vendor_id', $purchases_vendor_id)->update($validatedData);

    return redirect()->route('business.purchasvendor.edit', ['PurchasesVendor' => $PurchasVendoru->purchases_vendor_id])
        ->with('purchases-vendor-edit', __('messages.masteradmin.purchases-vendor.edit_purchasesvendor_success'));
}


    public function destroy($purchases_vendor_id): RedirectResponse
    {

        $user = Auth::guard('masteradmins')->user();

        $PurchasVendor = PurchasVendor::where(['purchases_vendor_id' => $purchases_vendor_id, 'id' => $user->id])->firstOrFail();

        $PurchasVendor->where('purchases_vendor_id', $purchases_vendor_id)->delete();
        return redirect()->route('business.purchasvendor.index')->with('purchases-vendor-delete', __('messages.masteradmin.purchases-vendor.delete_purchasesvendor_success'));

    }
    public function show($purchases_vendor_id): View
    {
        // Fetch the vendor details based on the ID
        $PurchasVendor = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();
        $Country = Countries::all(); // Fetch all countries
        $States = States::all();
    
        // Pass the vendor details, countries, and states to the view
        return view('masteradmin.vendor.view_vendor', compact('PurchasVendor', 'Country', 'States'));
    }
  
    public function addBankDetails(Request $request, $purchases_vendor_id)
    {
        $user = Auth::guard('masteradmins')->user();
    
        // Validate the incoming request
        $request->validate([
            'purchases_routing_number' => 'required|string|size:9', // Routing number must be exactly 9 digits
            'purchases_account_number' => 'required|string|digits_between:1,17', // Account number must be between 1 and 17 digits
            'bank_account_type' => 'required|string|in:checking,savings', // Ensure this field is required and only accepts valid values
        ], [
            'purchases_routing_number.required' => 'Routing number must be 9 digits.',
            'purchases_account_number.required' => 'Account number must be 1 to 17 digits.',
        ]);
    // );
    
        $validatedData = $request->only([
            'purchases_routing_number',
            'purchases_account_number',
            'bank_account_type',
        ]);
    
        // Add user ID to validated data
        $validatedData['id'] = $user->id;
        $validatedData['purchases_vendor_id'] = $purchases_vendor_id;
    
        // Store the bank details
        PurchasVendorBankDetail::create($validatedData);
        return redirect()->route('business.purchasvendor.index')->with('purchases-vendor-bankdetail', __('messages.masteradmin.purchases-vendor.add_bankdetail_success'));
        // return redirect()->back()->with('success', 'Bank details added successfully.');
    }
    
// public function viewBankDetails($purchases_vendor_id): View
// {
//     $PurchasVendorbank = PurchasVendorBankDetail::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();
//     return view('masteradmin.vendor.viewBankDetails', compact('PurchasVendorbank'));
// }


    public function viewBankDetails($purchases_vendor_id): View
    {
        $PurchasVendorbank = PurchasVendorBankDetail::where('purchases_vendor_id', $purchases_vendor_id)->with('vendor')->firstOrFail();
        return view('masteradmin.vendor.viewBankDetails', compact('PurchasVendorbank'));
    }
}

