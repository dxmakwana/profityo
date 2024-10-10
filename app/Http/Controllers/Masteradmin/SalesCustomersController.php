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
use App\Models\SentLog;
use App\Models\InvoicesDetails;
use App\Models\EstimatesItems;
use App\Models\CustomerContact;
use App\Models\InvoicesItems;

use Carbon\Carbon;


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
         //dd($request->all());
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
        $salesCustomer = SalesCustomers::create([
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
        
        $rawItems = $request->input('items');
        $groupedItems = [];
        if (is_array($rawItems) && count($rawItems) > 0) {
        for ($i = 0; $i < count($rawItems); $i += 3) {
            $groupedItems[] = [
                'cus_con_name' => $rawItems[$i]['cus_con_name'] ?? null,
                'cus_con_email' => $rawItems[$i + 1]['cus_con_email'] ?? null,
                'cus_con_phone' => $rawItems[$i + 2]['cus_con_phone'] ?? null,
            ];
        }
        }else{
            $groupedItems = [];
        }

        foreach ($groupedItems as $item) {
            $customerContact = new CustomerContact();
            
            $customerContact->fill($item);

            $customerContact->id = $user->id;
            $customerContact->sale_cus_id = $salesCustomer->id; 
            $customerContact->cus_con_status = 1;

            $customerContact->save();
        }

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

        $customerContact = CustomerContact::where('sale_cus_id', $sale_cus_id)->get();

        //dd($customerContact);
        

        // dd($State);
        // $State = States::all();
        // dd(\DB::getQueryLog()); // Show results of log
        return view('masteradmin.customers.edit', compact('SalesCustomerse','Country','State','ship_state','customerContact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sale_cus_id): RedirectResponse
    {
        // \DB::enableQueryLog(); // Enable query log


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
        ]);
        

        // Handle checkboxes: if not checked, they won't be present in the request
    //     $validatedData = $request->all();
   
        $validatedData['sale_same_address'] = $request->has('sale_same_address') ? 'on' : 'off';
    //     $validatedData['id'] = $user->id; // Use the correct field name for user ID
    //     $validatedData['sale_cus_status'] = 1;
    // dd($validatedData);
        $SalesCustomersu->where('sale_cus_id', $sale_cus_id)->update($validatedData);
        
        CustomerContact::where('sale_cus_id', $sale_cus_id)->delete();

        $rawItems = $request->input('items');
        $groupedItems = [];
        if (is_array($rawItems) && count($rawItems) > 0) {
        for ($i = 0; $i < count($rawItems); $i += 3) {
            $groupedItems[] = [
                'cus_con_name' => $rawItems[$i]['cus_con_name'] ?? null,
                'cus_con_email' => $rawItems[$i + 1]['cus_con_email'] ?? null,
                'cus_con_phone' => $rawItems[$i + 2]['cus_con_phone'] ?? null,
            ];
        }
        }else{
            $groupedItems = []; 
        }
        

        foreach ($groupedItems as $item) {
            $customerContact = new CustomerContact();
            
            $customerContact->fill($item);

            $customerContact->id = $user->id;
            $customerContact->sale_cus_id = $sale_cus_id; 
            $customerContact->cus_con_status = 1;

            $customerContact->save();
        }
     
        return redirect()->route('business.salescustomers.edit', ['SalesCustomers' => $SalesCustomersu->sale_cus_id])
        ->with('sales-customers-edit', __('messages.masteradmin.sales-customers.edit_salescustomers_success'));
    }


public function show($sale_cus_id, Request $request): View
{
    // dd($request->all());
    $user = Auth::guard('masteradmins')->user();
    $user_id = $user->user_id;
    $startDate = $request->input('start_date'); 
    $endDate = $request->input('end_date');

    $start_date_active = $request->input('start_date_active'); 
    $end_date_active = $request->input('end_date_active');
    
    // Fetch the customer details
    $SalesCustomers = SalesCustomers::where('sale_cus_id', $sale_cus_id)->firstOrFail();
    $Country = Countries::all(); 
    $States = States::all();

    // Fetch status filter from request for activity tab (if provided)
    $activityStatus = $request->input('activity_status');

    // Query for SentLog data (Activity data)
    $activityLogsQuery = SentLog::where('user_id', $user->id)
        ->where('cust_id', $sale_cus_id)
        ->with(['estimate', 'invoice']) 
        ->orderBy('created_at', 'desc');

        // if ($start_date_active && !$end_date_active) {
        //     $activityLogsQuery->whereRaw("STR_TO_DATE(created_at, '%m/%d/%Y') = STR_TO_DATE(?, '%m/%d/%Y')", [$start_date_active]);
        // } elseif ($start_date_active && $end_date_active) {
        //     $activityLogsQuery->whereRaw("STR_TO_DATE(created_at, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$start_date_active])
        //         ->whereRaw("STR_TO_DATE(created_at, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$end_date_active]);
        // }
        if ($start_date_active && !$end_date_active) {
            $activityLogsQuery->whereRaw("DATE(created_at) = ?", [Carbon::createFromFormat('m/d/Y', $start_date_active)->format('Y-m-d')]);
        } elseif ($start_date_active && $end_date_active) {
            $activityLogsQuery->whereRaw("DATE(created_at) >= ?", [Carbon::createFromFormat('m/d/Y', $start_date_active)->format('Y-m-d')])
                ->whereRaw("DATE(created_at) <= ?", [Carbon::createFromFormat('m/d/Y', $end_date_active)->format('Y-m-d')]);
        }
        
        // Additional filters for invoices
        if ($request->has('log_msg') && $request->log_msg) {
            $activityLogsQuery->where('log_msg', 'like', '%' . $request->log_msg . '%');
        }

    $sentLogs = $activityLogsQuery->get();

    // Existing logic for invoices
    $unpaidInvoices = InvoicesDetails::whereIn('sale_status', ['Unsent', 'Sent', 'Partial', 'Overdue'])
        ->where('sale_cus_id', $sale_cus_id)
        ->with('customer')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $query = InvoicesDetails::with('customer')->orderBy('created_at', 'desc');
    
    if ($startDate && !$endDate) {
        $query->whereRaw("STR_TO_DATE(sale_inv_date, '%m/%d/%Y') = STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);
    } elseif ($startDate && $endDate) {
        $query->whereRaw("STR_TO_DATE(sale_inv_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate])
            ->whereRaw("STR_TO_DATE(sale_inv_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);
    }

    // Additional filters for invoices
    if ($request->has('sale_inv_number') && $request->sale_inv_number) {
        $query->where('sale_inv_number', 'like', '%' . $request->sale_inv_number . '%');
    }

    if ($request->has('sale_status') && $request->sale_status) {
        $query->where('sale_status', $request->sale_status);
    }

    $filteredInvoices = $query->get();
    $allInvoices = $filteredInvoices->where('sale_cus_id', $sale_cus_id)->whereIn('sale_status', ['Unsent', 'Sent', 'Partial', 'Overdue']);
    $invoicesItems = InvoicesItems::where('sale_inv_id', $sale_cus_id)->with('invoices_product', 'item_tax')->get();
    // Handle AJAX request for activities
    if ($request->ajax()) {
        // Check if the request is for the activity tab
        if ($request->has('activity_filter')) {
            return view('masteradmin.customers.filtered_activity_results', compact('sentLogs', 'user_id'));
        } else {
            return view('masteradmin.customers.filtered_results', compact('unpaidInvoices', 'allInvoices', 'user_id'));
        }
    }

    // Pass the fetched data to the view
    return view('masteradmin.customers.view_customer', compact(
        'SalesCustomers', 'Country', 'States', 'unpaidInvoices', 'allInvoices', 'user_id', 'sentLogs', 'sentLogs', 'activityStatus'
    ));
}


private function getActivityLogs($user_id, $sale_cus_id, Request $request)
{
    // $status = $request->input('status'); // Activity log status
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $sentLogsQuery = SentLog::where('user_id', $user_id)
        ->where('cust_id', $sale_cus_id)
        ->with(['estimate', 'invoice']) // Eager load related estimates and invoices
        ->orderBy('created_at', 'desc');

    // Apply status filter if provided
    // if ($status) {
    //     $sentLogsQuery->where('status', $status);
    // }

    // Apply date filters
    if ($startDate && !$endDate) {
        $sentLogsQuery->whereRaw("DATE(created_at) = ?", [$startDate]);
    } elseif ($startDate && $endDate) {
        $sentLogsQuery->whereBetween('created_at', [$startDate, $endDate]);
    }


    // Return the filtered sent logs
    return $sentLogsQuery->get();
}





// end by dx.....
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
        $customer = SalesCustomers::where('sale_cus_id', $sale_cus_id)->first()->load('state', 'country','ship_state','bill_country');
        // dd($customer);
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
