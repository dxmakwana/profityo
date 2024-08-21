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
use App\Models\SalesCustomers;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesProduct;
use App\Models\SalesTax;
use App\Models\EstimatesItems;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\CustomizeMenu;
use App\Models\EstimateCustomizeMenu;
use Illuminate\Support\Facades\Session;

class EstimatesController extends Controller
{
    //
    public function index(): View
    {
        //
        // dd('hii');
        $activeEstimates = Estimates::where('sale_status', '1')->with('customer')->orderBy('created_at', 'desc')->get();
        $draftEstimates = Estimates::where('sale_status', '0')->with('customer')->orderBy('created_at', 'desc')->get();
        $allEstimates = Estimates::with('customer')->orderBy('created_at', 'desc')->get();
        // dd($allEstimates);
        return view('masteradmin.estimates.index', compact('activeEstimates', 'draftEstimates', 'allEstimates'));

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
        return view('masteradmin.estimates.add', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','specificMenus','HideMenus','HideSettings','HideDescription'));
    }

    public function getProductDetails($id)
    {
        $product = SalesProduct::where('sale_product_id', $id)->firstOrFail();
        // dd($product);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // dd($request->sale_currency_id);
      $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'required|integer',
            'sale_estim_number' => 'required|string|max:255',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_estim_date' => 'required|date',
            'sale_estim_valid_date' => 'required|date',
            'sale_estim_discount_desc' => 'nullable|string',
            'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
            'sale_currency_id' => 'nullable|numeric',
            'sale_estim_sub_total' => 'required|numeric',
            'sale_estim_discount_total' => 'required|numeric',
            'sale_estim_tax_amount' => 'required|numeric',
            'sale_estim_final_amount' => 'required|numeric',
            'sale_estim_notes' => 'nullable|string',
            'sale_estim_footer_note' => 'nullable|string',
            'sale_estim_image' => 'nullable|image',
            'sale_status' => 'required|integer',
            'sale_estim_item_discount' => 'nullable|integer',
            'sale_estim_status' => 'required|integer',
            'items.*.sale_product_id' => 'required|integer',
            'items.*.sale_estim_item_desc' => 'required|string',
            'items.*.sale_estim_item_qty' => 'required|integer|min:1',
            'items.*.sale_estim_item_price' => 'required|numeric|min:0',
            'items.*.sale_estim_item_tax' => 'required|integer',
        ], [
            'sale_estim_title.max' => 'The title may not exceed 255 characters.',
            'sale_cus_id.required' => 'Please select a customer.',
            'sale_cus_id.integer' => 'Please select a customer.',
            'sale_estim_number.required' => 'The estimate number is required.',
            'sale_estim_date.required' => 'Please select the estimate date.',
            'sale_estim_valid_date.required' => 'Please select the valid until date.',
            'sale_estim_discount_type.required' => 'Please select a discount type.',
            'sale_estim_discount_type.in' => 'The discount type must be either Dollar ($) or Percentage (%).',
            'sale_estim_sub_total.required' => 'Please enter the sub-total amount.',
            'sale_estim_discount_total.required' => 'Please enter the total discount amount.',
            'sale_estim_tax_amount.required' => 'Please enter the tax amount.',
            'sale_estim_final_amount.required' => 'Please enter the final amount.',
            'sale_estim_image.image' => 'The file uploaded must be a valid image.',
            'sale_status.required' => 'Please set the status of the estimate.',
            'sale_estim_status.required' => 'Please set the estimate status.',
            'items.*.sale_product_id.integer' => 'Each item must have a product selected.',
            'items.*.sale_estim_item_desc.required' => 'Please provide a description for each item.',
            'items.*.sale_estim_item_qty.required' => 'Please enter the quantity for each item.',
            'items.*.sale_estim_item_qty.min' => 'The quantity for each item must be at least 1.',
            'items.*.sale_estim_item_price.required' => 'Please enter the price for each item.',
            'items.*.sale_estim_item_price.min' => 'The price for each item must be at least 0.',
            'items.*.sale_estim_item_tax.required' => 'Please select the tax amount for each item.',
        ]);


        $estimate = new Estimates();
        $estimate->fill($request->only([
            'sale_estim_title', 'sale_estim_summary', 'sale_cus_id', 'sale_estim_number',
            'sale_estim_customer_ref', 'sale_estim_date', 'sale_estim_valid_date', 'sale_estim_item_discount', 'sale_estim_discount_desc', 'sale_estim_discount_type', 'sale_currency_id','sale_estim_sub_total', 'sale_estim_discount_total', 'sale_estim_tax_amount',
            'sale_estim_final_amount', 'sale_estim_notes', 'sale_estim_footer_note',
            'sale_estim_image', 'sale_status', 'sale_estim_status'
        ]));
        $user = Auth::guard('masteradmins')->user();
        $estimate->sale_estim_item_discount = $request->sale_estim_item_discount;
        $estimate->sale_currency_id = $request->sale_currency_id;
        $estimate->id = $user->id;
        // dd($estimate);
        $estimate->save();

        foreach ($request->input('items') as $item) {
            $estimateItem = new EstimatesItems();
            
            $estimateItem->fill($item);

            $estimateItem->id = $user->id;
            $estimateItem->sale_estim_id = $estimate->id; 
            $estimateItem->sale_estim_item_status = 1;

            $estimateItem->save();
        }

        $sessionData = session('form_data');
        // dd( $sessionssData);
            foreach ($sessionData as $key => $value) {
                $mname = str_replace('_', ' ', $key);

                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    $data = [
                        'sale_estim_id' => $estimate->id ?? null, 
                        'id' => $user->id ?? NULL,
                        'mname' => $menu->mname,
                        'mtitle' => $menu->mtitle,
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'esti_cust_menu_title' => $value,
                    ];

                    $estimateMenu = new EstimateCustomizeMenu($data);
                    $estimateMenu->save();
                }
            }

    
        // Clear the session data if necessary
        session()->forget('form_data');

        // return redirect()->route('business.estimates.index')->with(['estimate-add' => __('messages.masteradmin.estimate.send_success')]);
        \MasterLogActivity::addToLog('Estimate is create.');

        session()->flash('estimate-add', __('messages.masteradmin.estimate.send_success'));
        return response()->json([
            'redirect_url' => route('business.estimates.index'),
            'message' => __('messages.masteradmin.estimate.send_success')
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

        $estimates = Estimates::where('sale_estim_id', $id)->with('customer')->firstOrFail();

        $estimatesItems = EstimatesItems::where('sale_estim_id', $id)->get();

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
        return view('masteradmin.estimates.edit', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','estimates','estimatesItems','customer_states','ship_state'));

    }

    public function update(Request $request, $estimates_id)
    {
        // dd($request);
        // \DB::enableQueryLog();

        $user = Auth::guard('masteradmins')->user();

        $estimate = Estimates::where([
            'sale_estim_id' => $estimates_id,
            'id' => $user->id
        ])->firstOrFail();

        $validatedData = $request->validate([
            'sale_estim_title' => 'required|string|max:255',
            'sale_estim_summary' => 'required|string',
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

        // if()

        $estimate->sale_estim_item_discount = $validatedData['sale_estim_item_discount'];
        $estimate->sale_currency_id = $validatedData['sale_currency_id'];
        $estimate->where('sale_estim_id', $estimates_id)->update($validatedData);

        // dd(\DB::getQueryLog()); 
        // dd($estimate);
        
        EstimatesItems::where('sale_estim_id', $estimates_id)->delete();

        foreach ($request->input('items') as $item) {
            $estimateItem = new EstimatesItems();
            $estimateItem->fill($item);
            $estimateItem->id = $user->id; 
            $estimateItem->sale_estim_id = $estimates_id; 
            $estimateItem->sale_estim_item_status = 1;
            $estimateItem->save();
        }

        \MasterLogActivity::addToLog('Estimate is Edited.');
        session()->flash('estimate-edit', __('messages.masteradmin.estimate.edit_success'));

        return response()->json([
            'redirect_url' => route('business.estimates.edit', ['id' => $estimate->sale_estim_id]),
            'message' => __('messages.masteradmin.estimate.send_success')
        ]);

    }

    public function updateCustomer(Request $request, $sale_cus_id)
    {
        // dd($request);
        // Find the SalesCustomers by sale_cus_id
        $SalesCustomersu = SalesCustomers::where(['sale_cus_id' => $sale_cus_id])->firstOrFail();

        // Validate incoming request data
        $rules = [
            'sale_cus_business_name' => 'required|string|max:255',
            'sale_cus_first_name' => 'nullable|string|max:255',
            'sale_cus_last_name' => 'nullable|string|max:255',
            'sale_cus_email' => 'nullable|email|max:255',
            'sale_cus_phone' => 'nullable|numeric',
            'sale_cus_account_number' => 'nullable|numeric',
            'sale_cus_website' => 'nullable|string|max:255',
            'sale_cus_notes' => 'nullable|string|max:255',
            'sale_bill_currency_id' => 'nullable|numeric',
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
        ];

        $messages = [
           'sale_cus_business_name.required' => 'The business name is required.',
        'sale_cus_business_name.string' => 'The business name must be a valid string.',
        'sale_cus_first_name.string' => 'The first name must be a valid string.',
        'sale_cus_last_name.string' => 'The last name must be a valid string.',
        'sale_cus_email.email' => 'Please enter a valid email address.',
        'sale_cus_phone.numeric' => 'The phone number must be a valid numeric value.',
        'sale_cus_account_number.numeric' => 'The account number must be a valid numeric value.',
        'sale_cus_website.string' => 'The website must be a valid string.',
        'sale_cus_notes.string' => 'The notes must be a valid string.',
        'sale_bill_currency_id.numeric' => 'Please select a valid currency.',
        'sale_bill_address1.string' => 'The billing address line 1 must be a valid string.',
        'sale_bill_address2.string' => 'The billing address line 2 must be a valid string.',
        'sale_bill_country_id.numeric' => 'Please select a valid country.',
        'sale_bill_city_name.string' => 'The billing city name must be a valid string.',
        'sale_bill_zipcode.numeric' => 'The billing zip code must be a valid numeric value.',
        'sale_bill_state_id.numeric' => 'Please select a valid state.',
        'sale_ship_country_id.numeric' => 'Please select a valid shipping country.',
        'sale_ship_shipto.string' => 'The shipping recipient must be a valid string.',
        'sale_ship_address1.string' => 'The shipping address line 1 must be a valid string.',
        'sale_ship_address2.string' => 'The shipping address line 2 must be a valid string.',
        'sale_ship_city_name.string' => 'The shipping city name must be a valid string.',
        'sale_ship_zipcode.numeric' => 'The shipping zip code must be a valid numeric value.',
        'sale_ship_state_id.numeric' => 'Please select a valid shipping state.',
        'sale_ship_phone.numeric' => 'The shipping phone number must be a valid numeric value.',
        'sale_ship_delivery_desc.string' => 'The delivery description must be a valid string.',
        'sale_same_address.boolean' => 'The "Same Address" field must be true or false.',
        ];

        $validatedData = $request->validate($rules, $messages);

    
        // Handle checkboxes
        $validatedData['sale_same_address'] = $request->has('sale_same_address') ? 'on' : 'off';

        // Update the SalesCustomers record
        $SalesCustomersu->where(['sale_cus_id' => $sale_cus_id])->update($validatedData);

        

        $SalesCustomersu = SalesCustomers::where(['sale_cus_id' => $sale_cus_id])->firstOrFail();
        $SalesCustomersu->load('state', 'country');

        // Redirect with a success message
        // dd($SalesCustomersu);
        if ($SalesCustomersu) {
            return response()->json(['customer' => $SalesCustomersu]);
        } else {
            return response()->json(['error' => 'customer not found'], 404);
        }
    }

    public function listCustomers()
    {
        $customers = SalesCustomers::get(['sale_cus_id', 'sale_cus_business_name']);
        
        // dd($customers);
        return response()->json($customers);
    }

    //remove
    public function destroy($id): RedirectResponse
    {
        //
        $user = Auth::guard('masteradmins')->user();

        $estimates = Estimates::where(['sale_estim_id' => $id, 'id' => $user->id])->firstOrFail();

        // Delete the estimate details
        $estimates->where('sale_estim_id', $id)->delete();

        EstimatesItems::where('sale_estim_id', $id)->delete();

        EstimateCustomizeMenu::where('sale_estim_id', $id)->delete();

        \MasterLogActivity::addToLog('Estimates details Deleted.');

        return redirect()->route('business.estimates.index')->with('estimate-delete', __('messages.masteradmin.estimate.delete_success'));

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
}
