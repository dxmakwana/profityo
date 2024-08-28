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

        $sessionData = session('form_data', []);

        // dd( $sessionssData);
            foreach ($sessionData as $key => $value) {
                $mname = str_replace('_', ' ', $key);

                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    $data = [
                        'sale_inv_id' => $lastInsertedId ?? null, 
                        'id' => $user->id ?? NULL,
                        'mname' => $menu->mname,
                        'mtitle' => $menu->mtitle,
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'inv_cust_menu_title' => $value,
                    ];

                    $invoiceMenu = new InvoicesCustomizeMenu($data);
                    $invoiceMenu->save();
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

        // $states = States::get();

        // dd($estimates);
        return view('masteradmin.invoices.edit', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','invoices','invoicesItems','customer_states','ship_state'));

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


        // dd($businessDetails);
        return view('masteradmin.invoices.add', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','specificMenus','HideMenus','HideSettings','HideDescription'));
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
    
            $sessionData = session('form_data', []);
    
            // dd( $sessionssData);
                foreach ($sessionData as $key => $value) {
                    $mname = str_replace('_', ' ', $key);
    
                    $menu = CustomizeMenu::where('mname', $mname)->first();
    
                    if ($menu) {
                        $data = [
                            'sale_inv_id' => $lastInsertedId ?? null, 
                            'id' => $user->id ?? NULL,
                            'mname' => $menu->mname,
                            'mtitle' => $menu->mtitle,
                            'mid' => $menu->cust_menu_id,
                            'is_access' => $value ? 1 : 0,
                            'inv_cust_menu_title' => $value,
                        ];
    
                        $invoiceMenu = new InvoicesCustomizeMenu($data);
                        $invoiceMenu->save();
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


    
}
