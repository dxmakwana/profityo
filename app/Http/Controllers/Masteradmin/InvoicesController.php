<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoicesDetails;
use App\Models\InvoicesItems;
use App\Models\InvoicesCustomizeMenu;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomizeMenu;
use Illuminate\View\View;
use App\Models\BusinessDetails;
use App\Models\Countries;
use App\Models\States;
use App\Models\SalesCustomers;
use App\Models\SalesProduct;
use App\Models\SalesTax;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\InvoiceViewMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\SentLog;


class InvoicesController extends Controller
{
    //
    public function invoiceStore(Request $request)
    {
        // dd($request);
        // dd($request->sale_currency_id);
      $request->validate([
        'sale_estim_title' => 'nullable|string|max:255',
        'sale_estim_summary' => 'nullable|string',
        'sale_cus_id' => 'nullable|integer',
        'sale_estim_number' => 'required|string|max:255',
        'sale_estim_customer_ref' => 'nullable|string|max:255',
        'sale_estim_date' => 'required|date',
        'sale_estim_valid_date' => 'required|date',
        'sale_estim_discount_desc' => 'nullable|string',
        'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
        'sale_currency_id' => 'required|integer',
        'sale_estim_sub_total' => 'required|numeric',
        'sale_estim_discount_total' => 'required|numeric',
        'sale_estim_tax_amount' => 'required|numeric',
        'sale_estim_final_amount' => 'required|numeric',
        'sale_estim_notes' => 'nullable|string',
        'sale_estim_footer_note' => 'nullable|string',
        'sale_estim_image' => 'nullable|image',
        'sale_status' => 'required|integer',
        'sale_estim_item_discount' => 'nullable|integer',
        'sale_total_days' => 'required|integer',
       
        ]);


        $invoice = new InvoicesDetails();
        $user = Auth::guard('masteradmins')->user();
        $invoice->fill([
            'sale_inv_title' => $request->sale_estim_title,
            'sale_inv_summary' => $request->sale_estim_summary,
            'sale_cus_id' => $request->sale_cus_id,
            'sale_inv_number' => $request->sale_estim_number,
            'sale_inv_customer_ref' => $request->sale_estim_customer_ref,
            'sale_inv_date' => $request->sale_estim_date,
            'sale_inv_valid_date' => $request->sale_estim_valid_date,
            'sale_inv_discount_desc' => $request->sale_estim_discount_desc,
            'sale_inv_discount_type' => $request->sale_estim_discount_type,
            'sale_currency_id' => $request->sale_currency_id,
            'sale_inv_sub_total' => $request->sale_estim_sub_total,
            'sale_inv_discount_total' => $request->sale_estim_discount_total,
            'sale_inv_tax_amount' => $request->sale_estim_tax_amount,
            'sale_inv_final_amount' => $request->sale_estim_final_amount,
            'sale_inv_notes' => $request->sale_estim_notes,
            'sale_inv_footer_note' => $request->sale_estim_footer_note,
            'sale_status' => 'Draft',
            'sale_inv_item_discount' => $request->sale_estim_item_discount,
            'sale_total_days' => $request->sale_total_days,
            'sale_inv_status' => 1,
            'id' => $user->id,
        ]);
        
        $invoice->save();
        $lastInsertedId = $invoice->id;
        // dd($lastInsertedId);
        

        foreach ($request->input('items') as $item) {
            $invoiceItem = new InvoicesItems();
            
            $invoiceItem->sale_product_id = $item['sale_product_id'];
            $invoiceItem->sale_inv_item_qty = $item['sale_estim_item_qty'];
            $invoiceItem->sale_inv_item_price = $item['sale_estim_item_price'];
            $invoiceItem->sale_inv_item_tax = $item['sale_estim_item_tax'];
            $invoiceItem->sale_inv_item_desc = $item['sale_estim_item_desc'];
        
            $invoiceItem->id = $user->id;
            $invoiceItem->sale_inv_id = $lastInsertedId;
            $invoiceItem->sale_inv_item_status = 1;
                    
            $invoiceItem->save();
           
        }

        // Retrieve session data
        $sessionData = session('form_data') ?? [];
        InvoicesCustomizeMenu::where('sale_inv_id', $lastInsertedId)->delete();

        // Iterate through each item in session data
        foreach ($sessionData as $key => $value) {
            // Ignore _token and _method
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            // Check if the key has an "_other" counterpart
            if (strpos($key, '_other') === false) {
                $mname = str_replace('_', ' ', $key);
                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    // Check if the _other counterpart exists in the session
                    $otherKey = $key . '_other';
                    $otherValue = $sessionData[$otherKey] ?? null;

                    // Determine the mtitle value
                    if ($otherValue) {
                        // If there's an _other value, concatenate it with the main key value
                        $mtitle = $value;
                    } else {
                        // Use the main key value if no _other value
                        $mtitle = $value;
                    }

                    $data = [
                        'sale_inv_id' => $lastInsertedId ?? null,
                        'id' => $user->id ?? null,
                        'mname' => $menu->mname,
                        'mtitle' => $mtitle, // Set mtitle based on other_value if available
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'inv_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                    ];

                    // Update or create the record
                    InvoicesCustomizeMenu::updateOrCreate(
                        ['mname' => $menu->mname, 'sale_inv_id' => $lastInsertedId ?? null],
                        $data
                    );
                }
            }
        }

        // Clear the session data if necessary
        session()->forget('form_data');

      
        \MasterLogActivity::addToLog('Estimate is convert to invoice.');

        return response()->json([
            'redirect_url' => route('business.invoices.view', ['id' => $lastInsertedId]),
        ]);

    }

    public function view($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
        $user_id = $user->user_id;
        // dd($user_id);
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
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
        // dd($salecustomer['sale_cus_id']);

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
        // dd($currencys);
        
        $salestax = SalesTax::all();
        // dd($businessDetails);

        $invoices = InvoicesDetails::where('sale_inv_id', $id)->with('customer')->firstOrFail();

        $invoicesItems = InvoicesItems::where('sale_inv_id', $id)->with('invoices_product', 'item_tax')->get();
        // dd($estimatesItems);
        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        // $states = States::get();

        // dd($estimates);
        return view('masteradmin.invoices.view', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','invoices','invoicesItems','customer_states','ship_state','user_id'));

    }

    public function edit($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
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
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
        // dd($salecustomer['sale_cus_id']);

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
        // dd($currencys);
        
        $salestax = SalesTax::all();
        // dd($businessDetails);

        $invoices = InvoicesDetails::where('sale_inv_id', $id)->with('customer')->firstOrFail();

        $invoicesItems = InvoicesItems::where('sale_inv_id', $id)->get();

        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

        $invoiceCustomizeMenu = InvoicesCustomizeMenu::where('sale_inv_id', $id)->get();
        // $states = States::get();

        $invoicesCustomizeMenu = InvoicesCustomizeMenu::where('sale_inv_id', $id)->get();
      
        
        // $states = States::get();

        // dd($estimates);
        return view('masteradmin.invoices.edit', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','invoices','invoicesItems','customer_states','ship_state','specificMenus','HideMenus','HideSettings','HideDescription','invoiceCustomizeMenu','invoicesCustomizeMenu'));

    }

    public function update(Request $request, $invoice_id)
    {
        // dd($request);
        // \DB::enableQueryLog();

        $validatedData = $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'nullable|integer',
            'sale_estim_number' => 'required|string|max:255',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_estim_date' => 'required|date',
            'sale_estim_valid_date' => 'required|date',
            'sale_estim_discount_desc' => 'nullable|string',
            'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
            'sale_currency_id' => 'required|integer',
            'sale_estim_sub_total' => 'required|numeric',
            'sale_estim_discount_total' => 'required|numeric',
            'sale_estim_tax_amount' => 'required|numeric',
            'sale_estim_final_amount' => 'required|numeric',
            'sale_estim_notes' => 'nullable|string',
            'sale_estim_footer_note' => 'nullable|string',
            'sale_estim_image' => 'nullable|image',
            'sale_status' => 'required|integer',
            'sale_estim_item_discount' => 'nullable|integer',
            'sale_total_days' => 'required|integer',
        ]);

        $user = Auth::guard('masteradmins')->user();

        $invoice = InvoicesDetails::where([
            'sale_inv_id' => $invoice_id,
            'id' => $user->id
        ])->update([
            'sale_inv_title' => $request->sale_estim_title,
            'sale_inv_summary' => $request->sale_estim_summary,
            'sale_cus_id' => $request->sale_cus_id,
            'sale_inv_number' => $request->sale_estim_number,
            'sale_inv_customer_ref' => $request->sale_estim_customer_ref,
            'sale_inv_date' => $request->sale_estim_date,
            'sale_inv_valid_date' => $request->sale_estim_valid_date,
            'sale_inv_discount_desc' => $request->sale_estim_discount_desc,
            'sale_inv_discount_type' => $request->sale_estim_discount_type,
            'sale_currency_id' => $request->sale_currency_id,
            'sale_inv_sub_total' => $request->sale_estim_sub_total,
            'sale_inv_discount_total' => $request->sale_estim_discount_total,
            'sale_inv_tax_amount' => $request->sale_estim_tax_amount,
            'sale_inv_final_amount' => $request->sale_estim_final_amount,
            'sale_inv_notes' => $request->sale_estim_notes,
            'sale_inv_footer_note' => $request->sale_estim_footer_note,
            'sale_inv_item_discount' => $request->sale_estim_item_discount,
            'sale_total_days' => $request->sale_total_days
        ]);
        
        InvoicesItems::where('sale_inv_id', $invoice_id)->delete();

        foreach ($request->input('items') as $item) {
            $invoiceItem = new InvoicesItems();
            
            $invoiceItem->sale_product_id = $item['sale_product_id'];
            $invoiceItem->sale_inv_item_qty = $item['sale_estim_item_qty'];
            $invoiceItem->sale_inv_item_price = $item['sale_estim_item_price'];
            $invoiceItem->sale_inv_item_tax = $item['sale_estim_item_tax'];
            $invoiceItem->sale_inv_item_desc = $item['sale_estim_item_desc'];
        
            $invoiceItem->id = $user->id;
            $invoiceItem->sale_inv_id = $invoice_id;
            $invoiceItem->sale_inv_item_status = 1;
                    
            $invoiceItem->save();
        }

        // Retrieve session data
        $sessionData = session('form_data') ?? [];
        InvoicesCustomizeMenu::where('sale_inv_id', $invoice_id)->delete();

        // Iterate through each item in session data
        foreach ($sessionData as $key => $value) {
            // Ignore _token and _method
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            // Check if the key has an "_other" counterpart
            if (strpos($key, '_other') === false) {
                $mname = str_replace('_', ' ', $key);
                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    // Check if the _other counterpart exists in the session
                    $otherKey = $key . '_other';
                    $otherValue = $sessionData[$otherKey] ?? null;

                    // Determine the mtitle value
                    if ($otherValue) {
                        // If there's an _other value, concatenate it with the main key value
                        $mtitle = $value;
                    } else {
                        // Use the main key value if no _other value
                        $mtitle = $value;
                    }

                    $data = [
                        'sale_inv_id' => $invoice_id ?? null,
                        'id' => $user->id ?? null,
                        'mname' => $menu->mname,
                        'mtitle' => $mtitle, // Set mtitle based on other_value if available
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'inv_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                    ];

                    // Update or create the record
                    InvoicesCustomizeMenu::updateOrCreate(
                        ['mname' => $menu->mname, 'sale_inv_id' => $invoice_id ?? null],
                        $data
                    );
                }
            }
        }

        // Clear the session data if necessary
        session()->forget('form_data');

        \MasterLogActivity::addToLog('Invoice is Edited.');
        session()->flash('invoice-edit', __('messages.masteradmin.invoice.edit_success'));

        return response()->json([
            'redirect_url' => route('business.invoices.edit', ['id' => $invoice_id]),
            'message' => __('messages.masteradmin.invoice.send_success')
        ]);

    }

    public function create(): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
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

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
        // dd($currencys);
        
        $salestax = SalesTax::all();

        $customers = SalesCustomers::where('id', $user->id)->first();

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        $lastInvoice = InvoicesDetails::orderBy('sale_inv_id', 'desc')->first();

        $newId = $lastInvoice ? $lastInvoice->sale_inv_id + 1 : 1;
        // dd($businessDetails);
        return view('masteradmin.invoices.add', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','specificMenus','HideMenus','HideSettings','HideDescription','customer_states','ship_state','newId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'nullable|integer',
            'sale_estim_number' => 'required|string|max:255',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_estim_date' => 'required|date',
            'sale_estim_valid_date' => 'required|date',
            'sale_estim_discount_desc' => 'nullable|string',
            'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
            'sale_currency_id' => 'required|integer',
            'sale_estim_sub_total' => 'required|numeric',
            'sale_estim_discount_total' => 'required|numeric',
            'sale_estim_tax_amount' => 'required|numeric',
            'sale_estim_final_amount' => 'required|numeric',
            'sale_estim_notes' => 'nullable|string',
            'sale_estim_footer_note' => 'nullable|string',
            'sale_estim_image' => 'nullable|image',
            'sale_status' => 'required|integer',
            'sale_estim_item_discount' => 'nullable|integer',
            'sale_total_days' => 'required|integer',
           
            ]);
    
    
            $invoice = new InvoicesDetails();
            $user = Auth::guard('masteradmins')->user();
            $invoice->fill([
                'sale_inv_title' => $request->sale_estim_title,
                'sale_inv_summary' => $request->sale_estim_summary,
                'sale_cus_id' => $request->sale_cus_id,
                'sale_inv_number' => $request->sale_estim_number,
                'sale_inv_customer_ref' => $request->sale_estim_customer_ref,
                'sale_inv_date' => $request->sale_estim_date,
                'sale_inv_valid_date' => $request->sale_estim_valid_date,
                'sale_total_days' => $request->sale_total_days,
                'sale_inv_discount_desc' => $request->sale_estim_discount_desc,
                'sale_inv_discount_type' => $request->sale_estim_discount_type,
                'sale_currency_id' => $request->sale_currency_id,
                'sale_inv_sub_total' => $request->sale_estim_sub_total,
                'sale_inv_discount_total' => $request->sale_estim_discount_total,
                'sale_inv_tax_amount' => $request->sale_estim_tax_amount,
                'sale_inv_final_amount' => $request->sale_estim_final_amount,
                'sale_inv_notes' => $request->sale_estim_notes,
                'sale_inv_footer_note' => $request->sale_estim_footer_note,
                'sale_status' => 'Draft',
                'sale_inv_item_discount' => $request->sale_estim_item_discount,
                'sale_inv_status' => 1,
                'id' => $user->id,
            ]);
            
            $invoice->save();
            $lastInsertedId = $invoice->id;
            // dd($lastInsertedId);
    
            foreach ($request->input('items') as $item) {
                $invoiceItem = new InvoicesItems();
                
                $invoiceItem->sale_product_id = $item['sale_product_id'];
                $invoiceItem->sale_inv_item_qty = $item['sale_estim_item_qty'];
                $invoiceItem->sale_inv_item_price = $item['sale_estim_item_price'];
                $invoiceItem->sale_inv_item_tax = $item['sale_estim_item_tax'];
                $invoiceItem->sale_inv_item_desc = $item['sale_estim_item_desc'];
            
                $invoiceItem->id = $user->id;
                $invoiceItem->sale_inv_id = $lastInsertedId;
                $invoiceItem->sale_inv_item_status = 1;
                        
                $invoiceItem->save();
               
            }
    
            // Retrieve session data
        $sessionData = session('form_data') ?? [];

        // Iterate through each item in session data
        foreach ($sessionData as $key => $value) {
            // Ignore _token and _method
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            // Check if the key has an "_other" counterpart
            if (strpos($key, '_other') === false) {
                $mname = str_replace('_', ' ', $key);
                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    // Check if the _other counterpart exists in the session
                    $otherKey = $key . '_other';
                    $otherValue = $sessionData[$otherKey] ?? null;

                    // Determine the mtitle value
                    if ($otherValue) {
                        // If there's an _other value, concatenate it with the main key value
                        $mtitle = $value;
                    } else {
                        // Use the main key value if no _other value
                        $mtitle = $value;
                    }

                    $data = [
                        'sale_inv_id' => $lastInsertedId ?? null,
                        'id' => $user->id ?? null,
                        'mname' => $menu->mname,
                        'mtitle' => $mtitle, // Set mtitle based on other_value if available
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'inv_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                    ];

                    // Update or create the record
                    InvoicesCustomizeMenu::updateOrCreate(
                        ['mname' => $menu->mname, 'sale_inv_id' => $lastInsertedId ?? null],
                        $data
                    );
                }
            }
        }

        // Clear the session data if necessary
        session()->forget('form_data');

          
            \MasterLogActivity::addToLog('Estimate is Added.');
    
            return response()->json([
                'redirect_url' => route('business.invoices.view', ['id' => $lastInsertedId]),
            ]);
    

    }

    public function menuUpdate(Request $request) 
    {   
        // dd($request->all());
        Session::put('form_data', $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully'
        ]);

    }

    public function getMenuSessionData()
    {
        $sessionData = Session::get('form_data', []);
        // dd($sessionData);
        return response()->json($sessionData);
    }

    public function send(Request $request, $id, $slug)
    {
        $invoice = InvoicesDetails::where('sale_inv_id', $id)->firstOrFail();

        $validated = [
            'sale_status' => 'Sent', 
        ];

        $invoice->where('sale_inv_id', $id)->update($validated);

        // Encrypt the IDs
        $encryptedEstimateId = Crypt::encryptString($invoice->sale_inv_id);
        $encryptedUserID = Crypt::encryptString($slug);

        // Encode encrypted values to base64
        $encodedEstimateId = base64_encode($encryptedEstimateId);
        $encodedUserID = base64_encode($encryptedUserID);

        // Optionally, use a more URL-safe encoding
        $shortEncodedEstimateId = urlencode($encodedEstimateId);
        $shortEncodedUserID = urlencode($encodedUserID);
        
        $invoiceViewUrl = route('business.invoices.sendview', [$shortEncodedEstimateId, $shortEncodedUserID]);


        // dd($estimateViewUrl);

        $customer = SalesCustomers::where('sale_cus_id', $invoice->sale_cus_id)->first();
        if (!$customer || empty($customer->sale_cus_email)) {
            return back()->with('error', 'Customer email not found.');
        }

        \MasterLogActivity::addToLog('Admin Invoice Sent.');

        Mail::to($customer->sale_cus_email)->send(new InvoiceViewMail($invoiceViewUrl));

        $invoice_currency = Countries::find($invoice->sale_currency_id);

        $currencySymbol = $invoice_currency ? $invoice_currency->currency_symbol : '';
        
        $logMsg = "Invoice #{$invoice->sale_inv_number} for {$currencySymbol}{$invoice->sale_inv_final_amount}";
        // \DB::enableQueryLog();

        SentLog::create([
            'log_type' => '2',
            'user_id' => Auth::guard('masteradmins')->id(),
            'id' => $invoice->sale_inv_id,
            'cust_id'=> $invoice->sale_cus_id,
            'log_msg' => $logMsg,
            'status' => 'Sent',
            'log_status' => '1', 
        ]);

        return redirect()->back()->with('success', 'Invoice link sent to the customer successfully.');
    }

    public function sendView(Request $request, $id, $slug)
    {
        try {
            $id1= $id;
            $slug1 = $slug;
            $decodedEstimateId = urldecode($id);
            $decodedUserID = urldecode($slug);
    
            $base64EstimateId = base64_decode($decodedEstimateId);
            $base64UserID = base64_decode($decodedUserID);
    
            $decryptedEstimateId = Crypt::decryptString($base64EstimateId);
            $decryptedUserID = Crypt::decryptString($base64UserID);
            // dd($decryptedUserID);
            
            $tableName = $decryptedUserID . '_py_business_details';
            
            $businessDetails = \DB::table($tableName)
                ->join('py_states', 'py_states.id', '=', $tableName . '.state_id')
                ->join('py_countries', 'py_countries.id', '=', $tableName . '.country_id')
                ->select($tableName . '.*', 'py_states.name as state_name', 'py_countries.name as country_name')
                ->first();
            
            $tableNameCustomer = $decryptedUserID . '_py_sale_customers';
            $customers = \DB::table($tableNameCustomer)
                ->where('id', $businessDetails->id)
                ->first();

            $currencys = \DB::table('py_countries')->get();


            // $customers = SalesCustomers::where('id', $businessDetails->id)->first();
    
            // $currencys = Countries::all();

            $tableNameinvoice = $decryptedUserID . '_py_invoices_details';
            $tableNameStates = 'py_states'; // Assuming static names for states and countries
            $tableNameCountries = 'py_countries';

            $invoices = \DB::table($tableNameinvoice)
            ->leftJoin($tableNameCustomer, $tableNameCustomer . '.sale_cus_id', '=', $tableNameinvoice . '.sale_cus_id')
            // Join states and countries for billing address
            ->leftJoin($tableNameStates . ' as bill_states', 'bill_states.id', '=', $tableNameCustomer . '.sale_bill_state_id')
            ->leftJoin($tableNameCountries . ' as bill_countries', 'bill_countries.id', '=', $tableNameCustomer . '.sale_bill_country_id')
            // Join states and countries for shipping address
            ->leftJoin($tableNameStates . ' as ship_states', 'ship_states.id', '=', $tableNameCustomer . '.sale_ship_state_id')
            ->leftJoin($tableNameCountries . ' as ship_countries', 'ship_countries.id', '=', $tableNameCustomer . '.sale_ship_country_id')
            ->where($tableNameinvoice . '.sale_inv_id', $decryptedEstimateId)
            ->select(
                $tableNameinvoice . '.*',
                $tableNameCustomer . '.*',
                'bill_states.name as bill_state_name',
                'bill_countries.name as bill_country_name',
                'ship_states.name as ship_state_name',
                'ship_countries.name as ship_country_name'
            )
            ->first();
            
            $tableNameInvoiceItems = $decryptedUserID . '_py_invoices_items';
            $tableNameProduct = $decryptedUserID . '_py_sale_product';
            $tableNameTax = $decryptedUserID . '_py_sales_tax';

            $invoiceItems = \DB::table($tableNameInvoiceItems)
            ->leftJoin($tableNameProduct, $tableNameProduct . '.sale_product_id', '=', $tableNameInvoiceItems . '.sale_product_id')
            ->leftJoin($tableNameTax, $tableNameTax . '.tax_id', '=', $tableNameInvoiceItems . '.sale_inv_item_tax')
            ->where($tableNameInvoiceItems . '.sale_inv_id', $decryptedEstimateId)
            ->select(
                $tableNameInvoiceItems . '.*',
                $tableNameProduct . '.*',
                $tableNameTax . '.*'
            )
            ->get();

            $currency = $currencys->firstWhere('id', $invoices->sale_currency_id);

            if ($request->has('download')) {
                $pdf = PDF::loadView('masteradmin.invoices.pdf', compact('businessDetails', 'currencys', 'invoices', 'invoiceItems','currency','id','slug'))
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultMediaType', 'all')
                ->setOption('isFontSubsettingEnabled', true);

                // return $pdf->stream('estimate.pdf');
                return $pdf->download('invoice.pdf');
                        }

            return view('masteradmin.invoices.send', compact('businessDetails', 'currencys', 'invoices', 'invoiceItems','currency','id','slug'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid estimate link.');
        }
    }
    public function destroy($id)
    {
        //
        $user = Auth::guard('masteradmins')->user();

        $invoices = InvoicesDetails::where(['sale_inv_id' => $id, 'id' => $user->id])->firstOrFail();

        // Delete the estimate details
        $invoices->where('sale_inv_id', $id)->delete();

        InvoicesItems::where('sale_inv_id', $id)->delete();

        InvoicesCustomizeMenu::where('sale_inv_id', $id)->delete();

        \MasterLogActivity::addToLog('Invoice details Deleted.');

       
        return response()->json(['success' => true, 'message' => 'Estimate deleted successfully.']);
       

    }

    public function authsendView(Request $request, $id, $slug)
    {
        try {
            // dd('hiii');
            $id1= $id;
            $slug1 = $slug;
    
            $base64UserID =$id;
    
            $decryptedEstimateId = $id;
            $decryptedUserID = $slug;
            // dd($decryptedUserID);

            
            $tableName = $decryptedUserID . '_py_business_details';
         
            
            try {
                $businessDetails = \DB::table($tableName)
                    ->join('py_states', 'py_states.id', '=', $tableName . '.state_id')
                    ->join('py_countries', 'py_countries.id', '=', $tableName . '.country_id')
                    ->select($tableName . '.*', 'py_states.name as state_name', 'py_countries.name as country_name')
                    ->first();
            
                if (!$businessDetails) {
                    abort(404);
                }
            
            } catch (QueryException $e) {
                if ($e->getCode() == '42S02') {
                    abort(404); 
                } else {
                    throw $e;
                }
            }
            
            $tableNameCustomer = $decryptedUserID . '_py_sale_customers';
            $customers = \DB::table($tableNameCustomer)
                ->where('id', $businessDetails->id)
                ->first();


            $currencys = \DB::table('py_countries')->get();

            // $customers = SalesCustomers::where('id', $businessDetails->id)->first();
    
            // $currencys = Countries::all();

            $tableNameEstimates = $decryptedUserID . '_py_estimates_details';
            $tableNameStates = 'py_states'; 
            $tableNameCountries = 'py_countries';

            try {
                $tableNameinvoice = $decryptedUserID . '_py_invoices_details';
            $tableNameStates = 'py_states'; // Assuming static names for states and countries
            $tableNameCountries = 'py_countries';

            $invoices = \DB::table($tableNameinvoice)
            ->leftJoin($tableNameCustomer, $tableNameCustomer . '.sale_cus_id', '=', $tableNameinvoice . '.sale_cus_id')
            // Join states and countries for billing address
            ->leftJoin($tableNameStates . ' as bill_states', 'bill_states.id', '=', $tableNameCustomer . '.sale_bill_state_id')
            ->leftJoin($tableNameCountries . ' as bill_countries', 'bill_countries.id', '=', $tableNameCustomer . '.sale_bill_country_id')
            // Join states and countries for shipping address
            ->leftJoin($tableNameStates . ' as ship_states', 'ship_states.id', '=', $tableNameCustomer . '.sale_ship_state_id')
            ->leftJoin($tableNameCountries . ' as ship_countries', 'ship_countries.id', '=', $tableNameCustomer . '.sale_ship_country_id')
            ->where($tableNameinvoice . '.sale_inv_id', $decryptedEstimateId)
            ->select(
                $tableNameinvoice . '.*',
                $tableNameCustomer . '.*',
                'bill_states.name as bill_state_name',
                'bill_countries.name as bill_country_name',
                'ship_states.name as ship_state_name',
                'ship_countries.name as ship_country_name'
            )
            ->first();
            
                if (!$invoices) {
                    abort(404); 
                }
            
            } catch (QueryException $e) {
                if ($e->getCode() == '42S02') {
                    abort(404);
                } else {
                    throw $e;
                }
            }

           
            
            $tableNameInvoiceItems = $decryptedUserID . '_py_invoices_items';
            $tableNameProduct = $decryptedUserID . '_py_sale_product';
            $tableNameTax = $decryptedUserID . '_py_sales_tax';

            $invoiceItems = \DB::table($tableNameInvoiceItems)
            ->leftJoin($tableNameProduct, $tableNameProduct . '.sale_product_id', '=', $tableNameInvoiceItems . '.sale_product_id')
            ->leftJoin($tableNameTax, $tableNameTax . '.tax_id', '=', $tableNameInvoiceItems . '.sale_inv_item_tax')
            ->where($tableNameInvoiceItems . '.sale_inv_id', $decryptedEstimateId)
            ->select(
                $tableNameInvoiceItems . '.*',
                $tableNameProduct . '.*',
                $tableNameTax . '.*'
            )
            ->get();

            $currency = $currencys->firstWhere('id', $invoices->sale_currency_id);

            if ($request->has('download')) {
                $pdf = PDF::loadView('masteradmin.invoices.pdf', compact('businessDetails', 'currencys', 'invoices', 'invoiceItems','currency','id','slug'))
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultMediaType', 'all')
                ->setOption('isFontSubsettingEnabled', true);

                // return $pdf->stream('estimate.pdf');
                return $pdf->download('invoice.pdf');
                        }

            
            if ($request->has('print')) {

                return view('masteradmin.invoices.print', compact('businessDetails', 'currencys', 'invoices', 'invoiceItems','currency','id','slug'));
            }            

            return view('masteradmin.invoices.send', compact('businessDetails', 'currencys', 'invoices', 'invoiceItems','currency','id','slug'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid estimate link.');
        }
    }

    public function duplicate($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
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
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
        // dd($salecustomer['sale_cus_id']);

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
        // dd($currencys);
        
        $salestax = SalesTax::all();
        // dd($businessDetails);

        $invoices = InvoicesDetails::where('sale_inv_id', $id)->with('customer')->firstOrFail();

        $lastInvoice = InvoicesDetails::orderBy('sale_inv_id', 'desc')->first();

        $newId = $lastInvoice ? $lastInvoice->sale_inv_id + 1 : 1;
        // dd($newId);

        $invoicesItems = InvoicesItems::where('sale_inv_id', $id)->get();

        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        // $states = States::get();

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

        $invoiceCustomizeMenu = InvoicesCustomizeMenu::where('sale_inv_id', $id)->get();
        // $states = States::get();

        $invoicesCustomizeMenu = InvoicesCustomizeMenu::where('sale_inv_id', $id)->get();
      
        

        // dd($estimates);
        return view('masteradmin.invoices.duplicate', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','invoices','invoicesItems','customer_states','ship_state','newId','specificMenus','HideMenus','HideSettings','HideDescription','invoiceCustomizeMenu','invoicesCustomizeMenu'));
    }

    public function duplicateStore(Request $request)
    {
        // dd($request->sale_currency_id);
        $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'nullable|integer',
            'sale_estim_number' => 'required|string|max:255',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_estim_date' => 'required|date',
            'sale_estim_valid_date' => 'required|date',
            'sale_estim_discount_desc' => 'nullable|string',
            'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
            'sale_currency_id' => 'required|integer',
            'sale_estim_sub_total' => 'required|numeric',
            'sale_estim_discount_total' => 'required|numeric',
            'sale_estim_tax_amount' => 'required|numeric',
            'sale_estim_final_amount' => 'required|numeric',
            'sale_estim_notes' => 'nullable|string',
            'sale_estim_footer_note' => 'nullable|string',
            'sale_estim_image' => 'nullable|image',
            'sale_status' => 'required|integer',
            'sale_estim_item_discount' => 'nullable|integer',
            'sale_total_days' => 'nullable|integer',
           
            ]);
    
    
            $invoice = new InvoicesDetails();
            $user = Auth::guard('masteradmins')->user();
            $invoice->fill([
                'sale_inv_title' => $request->sale_estim_title,
                'sale_inv_summary' => $request->sale_estim_summary,
                'sale_cus_id' => $request->sale_cus_id,
                'sale_inv_number' => $request->sale_estim_number,
                'sale_inv_customer_ref' => $request->sale_estim_customer_ref,
                'sale_inv_date' => $request->sale_estim_date,
                'sale_inv_valid_date' => $request->sale_estim_valid_date,
                'sale_inv_discount_desc' => $request->sale_estim_discount_desc,
                'sale_inv_discount_type' => $request->sale_estim_discount_type,
                'sale_currency_id' => $request->sale_currency_id,
                'sale_inv_sub_total' => $request->sale_estim_sub_total,
                'sale_inv_discount_total' => $request->sale_estim_discount_total,
                'sale_inv_tax_amount' => $request->sale_estim_tax_amount,
                'sale_inv_final_amount' => $request->sale_estim_final_amount,
                'sale_inv_notes' => $request->sale_estim_notes,
                'sale_inv_footer_note' => $request->sale_estim_footer_note,
                'sale_status' => 'Draft',
                'sale_inv_item_discount' => $request->sale_estim_item_discount,
                'sale_total_days' => $request->sale_total_days,
                'sale_inv_status' => 1,
                'id' => $user->id,
            ]);
            
            $invoice->save();
            $lastInsertedId = $invoice->id;
            // dd($lastInsertedId);
            
    
            foreach ($request->input('items') as $item) {
                $invoiceItem = new InvoicesItems();
                
                $invoiceItem->sale_product_id = $item['sale_product_id'];
                $invoiceItem->sale_inv_item_qty = $item['sale_estim_item_qty'];
                $invoiceItem->sale_inv_item_price = $item['sale_estim_item_price'];
                $invoiceItem->sale_inv_item_tax = $item['sale_estim_item_tax'];
                $invoiceItem->sale_inv_item_desc = $item['sale_estim_item_desc'];
            
                $invoiceItem->id = $user->id;
                $invoiceItem->sale_inv_id = $lastInsertedId;
                $invoiceItem->sale_inv_item_status = 1;
                        
                $invoiceItem->save();
               
            }
    
            // Retrieve session data
        $sessionData = session('form_data') ?? [];
        InvoicesCustomizeMenu::where('sale_inv_id', $lastInsertedId)->delete();

        // Iterate through each item in session data
        foreach ($sessionData as $key => $value) {
            // Ignore _token and _method
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            // Check if the key has an "_other" counterpart
            if (strpos($key, '_other') === false) {
                $mname = str_replace('_', ' ', $key);
                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    // Check if the _other counterpart exists in the session
                    $otherKey = $key . '_other';
                    $otherValue = $sessionData[$otherKey] ?? null;

                    // Determine the mtitle value
                    if ($otherValue) {
                        // If there's an _other value, concatenate it with the main key value
                        $mtitle = $value;
                    } else {
                        // Use the main key value if no _other value
                        $mtitle = $value;
                    }

                    $data = [
                        'sale_inv_id' => $lastInsertedId ?? null,
                        'id' => $user->id ?? null,
                        'mname' => $menu->mname,
                        'mtitle' => $mtitle, // Set mtitle based on other_value if available
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'inv_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                    ];

                    // Update or create the record
                    InvoicesCustomizeMenu::updateOrCreate(
                        ['mname' => $menu->mname, 'sale_inv_id' => $lastInsertedId ?? null],
                        $data
                    );
                }
            }
        }

        // Clear the session data if necessary
        session()->forget('form_data');

      
        \MasterLogActivity::addToLog('Estimate is Duplicate.');

        return response()->json([
            'redirect_url' => route('business.invoices.view', ['id' => $lastInsertedId]),
        ]);

    }

    public function index(Request $request)
    {
        //
        // dd('hii');
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
        $user_id = $user->user_id;

        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');   
        // \DB::enableQueryLog();

        $query = InvoicesDetails::with('customer')->orderBy('created_at', 'desc');


        // if ($request->has('start_date') && $request->start_date) {
        //     $query->whereDate('sale_inv_date', '>=', $request->start_date);
        // }

        // if ($request->has('end_date') && $request->end_date) {
        //     $query->whereDate('sale_inv_date', '<=', $request->end_date);
        // }

        if ($startDate) {

            $query->whereRaw("STR_TO_DATE(sale_inv_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);

        }
    
        if ($endDate) {
            $query->whereRaw("STR_TO_DATE(sale_inv_valid_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);

        }

        if ($request->has('sale_inv_number') && $request->sale_inv_number) {
            $query->where('sale_inv_number', 'like', '%' . $request->sale_inv_number . '%');
        }

        if ($request->has('sale_cus_id') && $request->sale_cus_id) {
            $query->where('sale_cus_id', $request->sale_cus_id);
        }

        if ($request->has('sale_status') && $request->sale_status) {
            $query->where('sale_status', $request->sale_status);
        }

        $filteredInvoices = $query->get();

        $unpaidInvoices = $filteredInvoices->whereIn('sale_status', ['Unsent', 'Sent', 'Partlal','Overdue']);
        $draftInvoices = $filteredInvoices->where('sale_status', 'Draft');
        $allInvoices = $filteredInvoices;
        $salecustomer = SalesCustomers::get();

        if ($request->ajax()) {
            // dd(\DB::getQueryLog()); 
            // dd($allEstimates);
            return view('masteradmin.invoices.filtered_results', compact('unpaidInvoices', 'draftInvoices', 'allInvoices', 'user_id', 'salecustomer'))->render();
        }
      
        // dd($allEstimates);
        return view('masteradmin.invoices.index', compact('unpaidInvoices', 'draftInvoices', 'allInvoices','user_id','salecustomer'));

    }

    // public function statusStore(Request $request, $id)
    // {
    //     $user = Auth::guard('masteradmins')->user();

    //     $incoice = InvoicesDetails::where([
    //         'sale_inv_id' => $id,
    //         'id' => $user->id
    //     ])->firstOrFail();

    //     $validated = $request->validate([
    //         'sale_status' => 'required|string|max:255',
    //     ]);

    //     $incoice->where('sale_inv_id', $id)->update($validated);

    //     $response = ['success' => true, 'message' => 'Invoice saved successfully!'];
    //     if ($validated['sale_status'] === 'View') {
    //         $response['redirect_url'] = route('business.invoices.view', [ $incoice->sale_inv_id]); 
    //     }else
    //     if ($validated['sale_status'] === 'Sent') {
    //         $response['redirect_url'] = route('business.invoices.send', [ $incoice->sale_inv_id, $user->user_id]); 
    //     }

    //     return response()->json($response);
    // }


    public function statusStore(Request $request, $id)
    {
        $user = Auth::guard('masteradmins')->user();

        // Fetch the invoice record for the authenticated user and provided ID
        $invoices = InvoicesDetails::where([
            'sale_inv_id' => $id,
            'id' => $user->id
        ])->firstOrFail();

        // Define the status transition map
        $statusMap = [
            'Draft' => 'Unsent', // Clicking "Approve" changes "Draft" to "Saved"
            'Unsent' => 'Send', // Clicking "Send" changes "Saved" to "Sent"
            'Sent' => 'Record Payment', // Clicking "Convert to Invoice" changes "Sent" to "Converted"
            'Partlal' => 'Record Payment', // Clicking "Duplicate" changes "Converted" to "Duplicate"
            'Paid' => 'View', 
        ];
    

    $currentStatus = $invoices->sale_status;

    $nextStatus = $statusMap[$currentStatus] ?? null;

    // dd($nextStatus); // 

        if ($nextStatus) {

        
            $invoices->where('sale_inv_id', $id)->update(['sale_status' => $nextStatus]);
         

            $response = [
                'success' => true,
                'message' => "Invoice status updated to $nextStatus successfully!"
            ];
           
            switch ($nextStatus) {
               
                case 'Send':
                    $response['redirect_url'] = route('business.invoices.send', [$invoices->sale_inv_id, $user->user_id]);
                    break;

                case 'View':
                    $response['redirect_url'] = route('business.invoices.view', [$invoices->sale_inv_id]);
                    break;
              
                default:
                    $response['redirect_url'] = route('business.invoices.index'); // Assuming you have an index route
                    break;
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'No further status updates available!',
            ];
        }

        return response()->json($response);
    }

    
}
