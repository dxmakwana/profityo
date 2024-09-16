<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RecurringInvoices;
use App\Models\RecurringInvoicesItems;
use App\Models\SalesCustomers;
use Illuminate\View\View;
use App\Models\BusinessDetails;
use App\Models\Countries;
use App\Models\States;
use App\Models\SalesTax;
use App\Models\SalesProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\SentLog;
use App\Models\CustomizeMenu;
use App\Models\RecurringInvoicesCustomizeMenu;

class RecurringInvoicesController extends Controller
{
    //
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

        $query = RecurringInvoices::with('customer')->orderBy('created_at', 'desc');


        // if ($request->has('start_date') && $request->start_date) {
        //     $query->whereDate('sale_inv_date', '>=', $request->start_date);
        // }

        // if ($request->has('end_date') && $request->end_date) {
        //     $query->whereDate('sale_inv_date', '<=', $request->end_date);
        // }

        if ($request->has('sale_cus_id') && $request->sale_cus_id) {
            $query->where('sale_cus_id', $request->sale_cus_id);
        }

        $filteredreInvoices = $query->get();

        $activereInvoices = $filteredreInvoices->whereIn('sale_status', ['']);
        $draftreInvoices = $filteredreInvoices->where('sale_status', 'Draft');
        $allreInvoices = $filteredreInvoices;
        $salecustomer = SalesCustomers::get();

        if ($request->ajax()) {
            // dd(\DB::getQueryLog()); 
            // dd($allEstimates);
            return view('masteradmin.recurring_invoices.filtered_results', compact('activereInvoices', 'draftreInvoices', 'allreInvoices', 'user_id', 'salecustomer'))->render();
        }
      
        // dd($allEstimates);
        return view('masteradmin.recurring_invoices.index', compact('activereInvoices', 'draftreInvoices', 'allreInvoices','user_id','salecustomer'));

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

        $lastInvoice = RecurringInvoices::orderBy('sale_re_inv_id', 'desc')->first();

        $newId = $lastInvoice ? $lastInvoice->sale_re_inv_id + 1 : 1;
        // dd($businessDetails);
        return view('masteradmin.recurring_invoices.add', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','specificMenus','HideMenus','HideSettings','HideDescription','customer_states','ship_state','newId'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'nullable|integer',
            'sale_estim_number' => 'required|string|max:255',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_re_inv_payment_due_id' => 'required|integer',
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
            'sale_estim_item_discount' => 'nullable|integer',
           
            ],[
                'sale_estim_title.max' => 'The title may not exceed 255 characters.',
                'sale_cus_id.required' => 'Please select a customer.',
                'sale_cus_id.integer' => 'Please select a customer.',
                'sale_estim_number.required' => 'The estimate number is required.',
                'sale_re_inv_payment_due_id.required' => 'Please select the Payment Due.',
                'sale_estim_discount_type.required' => 'Please select a discount type.',
                'sale_estim_discount_type.in' => 'The discount type must be either Dollar ($) or Percentage (%).',
                'sale_estim_sub_total.required' => 'Please enter the sub-total amount.',
                'sale_estim_discount_total.required' => 'Please enter the total discount amount.',
                'sale_estim_tax_amount.required' => 'Please enter the tax amount.',
                'sale_estim_final_amount.required' => 'Please enter the final amount.',
                'sale_estim_image.image' => 'The file uploaded must be a valid image.',
            ]);
          
    
            $re_invoice = new RecurringInvoices();
            $user = Auth::guard('masteradmins')->user();
            $re_invoice->fill([
                'sale_re_inv_title' => $request->sale_estim_title,
                'sale_re_inv_summary' => $request->sale_estim_summary,
                'sale_cus_id' => $request->sale_cus_id,
                'sale_re_inv_number' => $request->sale_estim_number,
                'sale_re_inv_payment_due_id' => $request->sale_re_inv_payment_due_id,
                'sale_re_inv_customer_ref' => $request->sale_estim_customer_ref,
                'sale_re_inv_date' => now()->format('m/d/Y'),
                'sale_re_inv_valid_date' => now()->addDays($request->sale_re_inv_payment_due_id)->format('m/d/Y'),
                'sale_re_inv_discount_desc' => $request->sale_estim_discount_desc,
                'sale_re_inv_discount_type' => $request->sale_estim_discount_type,
                'sale_currency_id' => $request->sale_currency_id,
                'sale_re_inv_sub_total' => $request->sale_estim_sub_total,
                'sale_re_inv_discount_total' => $request->sale_estim_discount_total,
                'sale_re_inv_tax_amount' => $request->sale_estim_tax_amount,
                'sale_re_inv_final_amount' => $request->sale_estim_final_amount,
                'sale_re_inv_notes' => $request->sale_estim_notes,
                'sale_re_inv_footer_note' => $request->sale_estim_footer_note,
                'sale_status' => 'Draft',
                'sale_re_inv_item_discount' => $request->sale_estim_item_discount,
                'sale_re_inv_status' => 1,
                'id' => $user->id,
            ]);
            // dd($re_invoice);
            $re_invoice->save();
            $lastInsertedId = $re_invoice->id;
            // dd($lastInsertedId);
    
            foreach ($request->input('items') as $item) {
                $reinvoiceItem = new RecurringInvoicesItems();
                
                $reinvoiceItem->sale_product_id = $item['sale_product_id'];
                $reinvoiceItem->sale_re_inv_item_qty = $item['sale_estim_item_qty'];
                $reinvoiceItem->sale_re_inv_item_price = $item['sale_estim_item_price'];
                $reinvoiceItem->sale_re_inv_item_tax = $item['sale_estim_item_tax'];
                $reinvoiceItem->sale_re_inv_item_desc = $item['sale_estim_item_desc'];
            
                $reinvoiceItem->id = $user->id;
                $reinvoiceItem->sale_re_inv_id = $lastInsertedId;
                $reinvoiceItem->sale_re_inv_item_status = 1;
                        
                $reinvoiceItem->save();
               
            }
    
            // $sessionData = session('form_data', []);

            $sessionData = session('form_data') ?? [];
    
            // dd( $sessionssData);
                foreach ($sessionData as $key => $value) {
                    $mname = str_replace('_', ' ', $key);
    
                    $menu = CustomizeMenu::where('mname', $mname)->first();
    
                    if ($menu) {
                        $data = [
                            'sale_re_inv_id' => $lastInsertedId ?? null, 
                            'id' => $user->id ?? NULL,
                            'mname' => $menu->mname,
                            'mtitle' => $menu->mtitle,
                            'mid' => $menu->cust_menu_id,
                            'is_access' => $value ? 1 : 0,
                            're_inv_cust_menu_title' => $value,
                        ];
    
                        $reinvoiceMenu = new RecurringInvoicesCustomizeMenu($data);
                        $reinvoiceMenu->save();
                    }
                }
    
        
            // Clear the session data if necessary
            session()->forget('form_data');
          
            \MasterLogActivity::addToLog('Recurring Invoices is Added.');
    
            return response()->json([
                'redirect_url' => route('business.recurring_invoices.view', ['id' => $lastInsertedId]),
            ]);
    

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

        $reinvoices = RecurringInvoices::where('sale_re_inv_id', $id)->with('customer')->firstOrFail();

        $reinvoicesItems = RecurringInvoicesItems::where('sale_re_inv_id', $id)->get();

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
        return view('masteradmin.recurring_invoices.edit', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','reinvoices','reinvoicesItems','customer_states','ship_state'));

    }

    public function update(Request $request, $reinvoice_id)
    {
        // dd($request->all());
        // \DB::enableQueryLog();

        $validatedData = $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'nullable|integer',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
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

        $invoice = RecurringInvoices::where([
            'sale_re_inv_id' => $reinvoice_id,
            'id' => $user->id
        ])->update([
            'sale_re_inv_title' => $request->sale_estim_title,
            'sale_re_inv_summary' => $request->sale_estim_summary,
            'sale_cus_id' => $request->sale_cus_id,
            'sale_re_inv_payment_due_id' => $request->sale_re_inv_payment_due_id,
            'sale_re_inv_valid_date' => now()->addDays($request->sale_re_inv_payment_due_id)->format('m/d/Y'),
            'sale_re_inv_customer_ref' => $request->sale_estim_customer_ref,
            'sale_re_inv_discount_desc' => $request->sale_estim_discount_desc,
            'sale_re_inv_discount_type' => $request->sale_estim_discount_type,
            'sale_currency_id' => $request->sale_currency_id,
            'sale_re_inv_sub_total' => $request->sale_estim_sub_total,
            'sale_re_inv_discount_total' => $request->sale_estim_discount_total,
            'sale_re_inv_tax_amount' => $request->sale_estim_tax_amount,
            'sale_re_inv_final_amount' => $request->sale_estim_final_amount,
            'sale_re_inv_notes' => $request->sale_estim_notes,
            'sale_re_inv_footer_note' => $request->sale_estim_footer_note,
            'sale_re_inv_item_discount' => $request->sale_estim_item_discount,
        ]);
        
        RecurringInvoicesItems::where('sale_re_inv_id', $reinvoice_id)->delete();

        foreach ($request->input('items') as $item) {
            $reinvoiceItem = new RecurringInvoicesItems();
            
            $reinvoiceItem->sale_product_id = $item['sale_product_id'];
            $reinvoiceItem->sale_re_inv_item_qty = $item['sale_estim_item_qty'];
            $reinvoiceItem->sale_re_inv_item_price = $item['sale_estim_item_price'];
            $reinvoiceItem->sale_re_inv_item_tax = $item['sale_estim_item_tax'];
            $reinvoiceItem->sale_re_inv_item_desc = $item['sale_estim_item_desc'];
        
            $reinvoiceItem->id = $user->id;
            $reinvoiceItem->sale_re_inv_id = $reinvoice_id;
            $reinvoiceItem->sale_re_inv_item_status = 1;
                    
            $reinvoiceItem->save();
        }

        \MasterLogActivity::addToLog('Recurring Invoices is Edited.');
        session()->flash('reinvoice-edit', __('messages.masteradmin.re-invoice.edit_success'));

        return response()->json([
            'redirect_url' => route('business.recurring_invoices.edit', ['id' => $reinvoice_id]),
            'message' => __('messages.masteradmin.re-invoice.edit_success')
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

        $reinvoices = RecurringInvoices::where('sale_re_inv_id', $id)->with('customer')->firstOrFail();

        $reinvoicesItems = RecurringInvoicesItems::where('sale_re_inv_id', $id)->with('invoices_product', 'item_tax')->get();
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
        return view('masteradmin.recurring_invoices.view', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','reinvoices','reinvoicesItems','customer_states','ship_state','user_id'));

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

        $reinvoices = RecurringInvoices::where('sale_re_inv_id', $id)->with('customer')->firstOrFail();

        $lastInvoice = RecurringInvoices::orderBy('sale_re_inv_id', 'desc')->first();

        $newId = $lastInvoice ? $lastInvoice->sale_re_inv_id + 1 : 1;
        // dd($newId);

        $reinvoicesItems = RecurringInvoicesItems::where('sale_re_inv_id', $id)->get();

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
        return view('masteradmin.recurring_invoices.duplicate', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','reinvoices','reinvoicesItems','customer_states','ship_state','newId'));
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
    
    
            $invoice = new RecurringInvoices();
            $user = Auth::guard('masteradmins')->user();
            $invoice->fill([
                'sale_re_inv_title' => $request->sale_estim_title,
                'sale_re_inv_summary' => $request->sale_estim_summary,
                'sale_cus_id' => $request->sale_cus_id,
                'sale_re_inv_number' => $request->sale_estim_number,
                'sale_re_inv_payment_due_id' => $request->sale_re_inv_payment_due_id,
                'sale_re_inv_customer_ref' => $request->sale_estim_customer_ref,
                'sale_re_inv_date' => now()->format('m/d/Y'),
                'sale_re_inv_valid_date' => now()->addDays($request->sale_re_inv_payment_due_id)->format('m/d/Y'),
                'sale_re_inv_discount_desc' => $request->sale_estim_discount_desc,
                'sale_re_inv_discount_type' => $request->sale_estim_discount_type,
                'sale_currency_id' => $request->sale_currency_id,
                'sale_re_inv_sub_total' => $request->sale_estim_sub_total,
                'sale_re_inv_discount_total' => $request->sale_estim_discount_total,
                'sale_re_inv_tax_amount' => $request->sale_estim_tax_amount,
                'sale_re_inv_final_amount' => $request->sale_estim_final_amount,
                'sale_re_inv_notes' => $request->sale_estim_notes,
                'sale_re_inv_footer_note' => $request->sale_estim_footer_note,
                'sale_status' => 'Draft',
                'sale_re_inv_item_discount' => $request->sale_estim_item_discount,
                'sale_re_inv_status' => 1,
                'id' => $user->id,
            ]);
            
            $invoice->save();
            $lastInsertedId = $invoice->id;
            // dd($lastInsertedId);
            
    
            foreach ($request->input('items') as $item) {
                $reinvoiceItem = new RecurringInvoicesItems();
                
                $reinvoiceItem->sale_product_id = $item['sale_product_id'];
                $reinvoiceItem->sale_re_inv_item_qty = $item['sale_estim_item_qty'];
                $reinvoiceItem->sale_re_inv_item_price = $item['sale_estim_item_price'];
                $reinvoiceItem->sale_re_inv_item_tax = $item['sale_estim_item_tax'];
                $reinvoiceItem->sale_re_inv_item_desc = $item['sale_estim_item_desc'];
            
                $reinvoiceItem->id = $user->id;
                $reinvoiceItem->sale_re_inv_id = $lastInsertedId;
                $reinvoiceItem->sale_re_inv_item_status = 1;
                        
                $reinvoiceItem->save();
               
            }
    
            $sessionData = session('form_data', []);
    
            // dd( $sessionssData);
                foreach ($sessionData as $key => $value) {
                    $mname = str_replace('_', ' ', $key);
    
                    $menu = CustomizeMenu::where('mname', $mname)->first();
    
                    if ($menu) {
                        $data = [
                            'sale_re_inv_id' => $lastInsertedId ?? null, 
                            'id' => $user->id ?? NULL,
                            'mname' => $menu->mname,
                            'mtitle' => $menu->mtitle,
                            'mid' => $menu->cust_menu_id,
                            'is_access' => $value ? 1 : 0,
                            're_inv_cust_menu_title' => $value,
                        ];
    
                        $invoiceMenu = new RecurringInvoicesCustomizeMenu($data);
                        $invoiceMenu->save();
                    }
                }
    
        
        // Clear the session data if necessary
        session()->forget('form_data');
      
        \MasterLogActivity::addToLog('Recurring Invoice is Duplicate.');

        return response()->json([
            'redirect_url' => route('business.recurring_invoices.view', ['id' => $lastInsertedId]),
        ]);

    }

}
