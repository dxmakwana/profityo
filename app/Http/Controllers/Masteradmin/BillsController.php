<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use App\Models\PurchasProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Bills;
use App\Models\BillsItems;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchasVendor;
use App\Models\CustomizeMenu;
use App\Models\Countries;
use App\Models\States;
use App\Models\SalesTax;
use App\Models\BusinessDetails;
use App\Models\ChartAccount;


class BillsController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd($request->sale_status);

        $user = Auth::guard('masteradmins')->user();
        $user_id = $user->user_id;
        // \DB::enableQueryLog();
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');   
        $query = Bills::with('vendor')->orderBy('sale_bill_id', 'desc');

        // if ($request->has('start_date') && $request->start_date) {
        //     $query->whereDate('sale_estim_date', '>=', $request->start_date);
        // }

        // if ($request->has('end_date') && $request->end_date) {
        //     $query->whereDate('sale_estim_date', '<=', $request->end_date);
        // }

        if ($startDate) {
            $query->whereRaw("STR_TO_DATE(sale_bill_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);
        }
    
        if ($endDate) {
            $query->whereRaw("STR_TO_DATE(sale_bill_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);
        }

        if ($request->has('sale_vendor_id') && $request->sale_vendor_id) {
            $query->where('sale_vendor_id', $request->sale_vendor_id);
        }

        $filteredBill = $query->get();

        $allBill = $filteredBill;
        $vendor = PurchasVendor::get();
    
        if ($request->ajax()) {
            // dd(\DB::getQueryLog()); 
            // dd($allEstimates);
            return view('masteradmin.bills.filtered_results', compact('allBill', 'user_id', 'vendor'))->render();
        }
        
        return view('masteradmin.bills.index', compact('allBill', 'user_id', 'vendor'));
    }

    public function create($id = null): View
    {
        // dd($id);
        $customer_id = $id;
        $user = Auth::guard('masteradmins')->user();
        // dd($user);

        $salevendor = PurchasVendor::where('id', $user->id)->get();

        $products = PurchasProduct::where('id', $user->id)->get();
        
        $currencys = Countries::get();
        // dd($currencys);
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get();

        $salestax = SalesTax::all();

        $vendors = PurchasVendor::where('id', $user->id)->first();

       
        $customer_states = collect();
        if ($vendors && $vendors->sale_bill_country_id) {
            $customer_states = States::where('country_id', $vendors->purchases_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($vendors && $vendors->sale_ship_country_id) {
            $ship_state = States::where('country_id', $vendors->purchases_ship_country_id)->get();
        }

        $selected_vendor = PurchasVendor::with(['state', 'country'])->where([ 'id' => $user->id , 'purchases_vendor_id' => $id])->first();


        // dd($businessDetails);
        return view('masteradmin.bills.add', compact('salevendor','products','currencys','salestax','customer_states','ship_state','currency','vendors','ExpenseAccounts','selected_vendor'));
    }

    public function getProductDetails($id)
    {
        $product = PurchasProduct::where('purchases_product_id', $id)->firstOrFail();
        // dd($product);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // $sessionData = session('form_data');
        // dd($request);
        // dd($request->sale_currency_id);
      $request->validate([
            'sale_vendor_id' => 'required|integer',
            'sale_bill_number' => 'required|string|max:255',
            'sale_bill_customer_ref' => 'nullable|string|max:255',
            'sale_bill_date' => 'required|date',
            'sale_bill_valid_date' => 'required|date',
            'sale_currency_id' => 'nullable|numeric',
            'sale_bill_sub_total' => 'required|numeric',
            'sale_bill_tax_amount' => 'required|numeric',
            'sale_bill_final_amount' => 'required|numeric',
            'sale_bill_note' => 'nullable|string',
            'sale_status' => 'required|integer',
            'sale_bill_status' => 'required|integer',
            'items.*.sale_product_id' => 'required|integer',
            'items.*.sale_bill_item_desc' => 'required|string',
            'items.*.sale_expense_id' => 'required|string',
            'items.*.sale_bill_item_qty' => 'required|integer|min:1',
            'items.*.sale_bill_item_price' => 'required|numeric|min:0',
            'items.*.sale_bill_item_tax' => 'required|integer',
        ], [
            'sale_vendor_id.required' => 'Please select a vendor.',
            'sale_vendor_id.integer' => 'Please select a vendor.',
            'sale_bill_number.required' => 'The bill number is required.',
            'sale_bill_date.required' => 'Please select the bill date.',
            'sale_bill_valid_date.required' => 'Please select the valid until date.',
            'sale_bill_sub_total.required' => 'Please enter the sub-total amount.',
            'sale_bill_tax_amount.required' => 'Please enter the tax amount.',
            'sale_bill_final_amount.required' => 'Please enter the final amount.',
            'sale_bill_image.image' => 'The file uploaded must be a valid image.',
            'sale_status.required' => 'Please set the status of the bill.',
            'sale_bill_status.required' => 'Please set the bill status.',
            'items.*.sale_product_id.integer' => 'Each item must have a product selected.',
            'items.*.sale_bill_item_desc.required' => 'Please provide a description for each item.',
            'items.*.sale_expense_id.required' => 'Please enter the quantity for each item.',
            'items.*.sale_bill_item_qty.required' => 'The quantity for each item must be at least 1.',
            'items.*.sale_bill_item_price.required' => 'Please enter the price for each item.',
            'items.*.sale_bill_item_price.min' => 'The price for each item must be at least 0.',
            'items.*.sale_bill_item_tax.required' => 'Please select the tax amount for each item.',
        ]);
        // \DB::enableQueryLog();


        $bill = new Bills();
       
        $bill->fill(attributes: $request->only([
            'sale_vendor_id', 'sale_bill_number','sale_bill_customer_ref', 'sale_bill_date', 
            'sale_bill_valid_date',  'sale_currency_id','sale_bill_sub_total', 'sale_bill_tax_amount',
            'sale_bill_final_amount', 'sale_bill_note', 'sale_status', 'sale_bill_status'
        ]));
        $user = Auth::guard('masteradmins')->user();
        $bill->sale_currency_id = $request->sale_currency_id;
        $bill->sale_bill_paid_amount = 0;
        $bill->sale_bill_due_amount = $request->sale_bill_final_amount;
        $bill->id = $user->id;
        $bill->sale_status = 'Unpaid';
        // dd($estimate);
        $bill->save();

        foreach ($request->input('items') as $item) {
            $billItem = new BillsItems();
            
            $billItem->fill($item);

            $billItem->id = $user->id;
            $billItem->sale_bill_id = $bill->id; 
            $billItem->sale_bill_item_status = 1;

            $billItem->save();
        }
        // dd(\DB::getQueryLog()); 
        \MasterLogActivity::addToLog('Bill is create.');

        session()->flash('bill-add', __('messages.masteradmin.bill.send_success'));
        return response()->json([
            'redirect_url' => route('business.bill.index'),
            'message' => __('messages.masteradmin.bill.send_success')
        ]);

    }

    public function edit($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);

        $salevendor = PurchasVendor::where('id', $user->id)->get();
        
        $products = PurchasProduct::where('id', $user->id)->get();
        
        $currencys = Countries::get();
        // dd($currencys);
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get();

        $salestax = SalesTax::all();

        $vendors = PurchasVendor::where('id', $user->id)->first();

       
        $customer_states = collect();
        if ($vendors && $vendors->sale_bill_country_id) {
            $customer_states = States::where('country_id', $vendors->purchases_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($vendors && $vendors->sale_ship_country_id) {
            $ship_state = States::where('country_id', $vendors->purchases_ship_country_id)->get();
        }

        // $bill = Bills::where('sale_bill_id', $id)->with('vendor')->firstOrFail();
        // dd( $bill );
        $bill = Bills::where('sale_bill_id', $id)
        ->with(['vendor.state', 'vendor.country'])
        ->firstOrFail();

        $billsItems = BillsItems::where('sale_bill_id', $id)->get();

        // dd($businessDetails);
        return view('masteradmin.bills.edit', compact('salevendor','products','currencys','salestax','customer_states','ship_state','currency','vendors','ExpenseAccounts','bill','billsItems'));

    }

    public function update(Request $request, $id)
    {
        // dd($request);
        // \DB::enableQueryLog();

        $user = Auth::guard('masteradmins')->user();

        $bill = Bills::where([
            'sale_bill_id' => $id,
            'id' => $user->id
        ])->firstOrFail();
            // dd($request->sale_bill_final_amount);
        $validatedData = $request->validate([
            'sale_vendor_id' => 'nullable|integer',
            'sale_bill_number' => 'required|string|max:255',
            'sale_bill_customer_ref' => 'nullable|string|max:255',
            'sale_bill_date' => 'required|date',
            'sale_bill_valid_date' => 'required|date',
            'sale_currency_id' => 'required|integer',
            'sale_bill_sub_total' => 'required|numeric',
            'sale_bill_tax_amount' => 'required|numeric',
            'sale_bill_final_amount' => 'required|numeric',
            'sale_bill_note' => 'nullable|string',
            'sale_status' => 'required|integer', 
        ]);

        // if()

        $bill->sale_currency_id = $validatedData['sale_currency_id'];
        $bill->sale_bill_final_amount = $request->sale_bill_final_amount;
        $validatedData['sale_bill_due_amount'] = $request->sale_bill_final_amount; // Set due amount
        $validatedData['sale_bill_paid_amount'] = 0;
        $validatedData['sale_status'] =  $bill->sale_status;
        
        // dd($bill);
        $bill->where('sale_bill_id', $id)->update($validatedData);

        // dd(\DB::getQueryLog()); 
        // dd($estimate);
        
        BillsItems::where('sale_bill_id', $id)->delete();

        foreach ($request->input('items') as $item) {
            $billItem = new BillsItems();
            $billItem->fill($item);
            $billItem->id = $user->id; 
            $billItem->sale_bill_id = $id; 
            $billItem->sale_bill_item_status = 1;
            $billItem->save();
        }

        \MasterLogActivity::addToLog('Bill is Edited.');
        session()->flash('bill-edit', __('messages.masteradmin.bill.edit_success'));

        return response()->json([
            'redirect_url' => route('business.bill.edit', ['id' => $bill->sale_bill_id]),
            'message' => __('messages.masteradmin.bill.edit_success')
        ]);

    }

    public function destroy($id)
    {
        //
        $user = Auth::guard('masteradmins')->user();

        $bills = Bills::where(['sale_bill_id' => $id, 'id' => $user->id])->firstOrFail();

        // Delete the estimate details
        $bills->where('sale_bill_id', $id)->delete();

        BillsItems::where('sale_bill_id', $id)->delete();

        \MasterLogActivity::addToLog('Bill is Deleted.');
       
        return response()->json(['success' => true, 'message' => 'Bill deleted successfully.']);
       

        // return redirect()->route('business.estimates.index')->with('estimate-delete', __('messages.masteradmin.estimate.delete_success'));

    }

    public function view($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);

        $salevendor = PurchasVendor::where('id', $user->id)->get();
        
        $products = PurchasProduct::where('id', $user->id)->get();
        
        $currencys = Countries::get();
        // dd($currencys);
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get();

        $salestax = SalesTax::all();

        $vendors = PurchasVendor::where('id', $user->id)->first();

       
        $customer_states = collect();
        if ($vendors && $vendors->sale_bill_country_id) {
            $customer_states = States::where('country_id', $vendors->purchases_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($vendors && $vendors->sale_ship_country_id) {
            $ship_state = States::where('country_id', $vendors->purchases_ship_country_id)->get();
        }

        // $bill = Bills::where('sale_bill_id', $id)->with('vendor')->firstOrFail();
        // dd( $bill );
        $bill = Bills::where('sale_bill_id', $id)
        ->with(['vendor.state', 'vendor.country'])
        ->firstOrFail();

        $billsItems = BillsItems::where('sale_bill_id', $id)->with('bill_product', 'item_tax','expense_category')->get();

        // dd($businessDetails);
        return view('masteradmin.bills.view', compact('salevendor','products','currencys','salestax','customer_states','ship_state','currency','vendors','ExpenseAccounts','bill','billsItems'));

    }

    public function duplicate($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);

        $salevendor = PurchasVendor::where('id', $user->id)->get();
        
        $products = PurchasProduct::where('id', $user->id)->get();
        
        $currencys = Countries::get();
        // dd($currencys);
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get();

        $salestax = SalesTax::all();

        $vendors = PurchasVendor::where('id', $user->id)->first();

       
        $customer_states = collect();
        if ($vendors && $vendors->sale_bill_country_id) {
            $customer_states = States::where('country_id', $vendors->purchases_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($vendors && $vendors->sale_ship_country_id) {
            $ship_state = States::where('country_id', $vendors->purchases_ship_country_id)->get();
        }

        // $bill = Bills::where('sale_bill_id', $id)->with('vendor')->firstOrFail();
        // dd( $bill );
        $bill = Bills::where('sale_bill_id', $id)
        ->with(['vendor.state', 'vendor.country'])
        ->firstOrFail();

        $billsItems = BillsItems::where('sale_bill_id', $id)->get();

        // dd($businessDetails);
        return view('masteradmin.bills.duplicate', compact('salevendor','products','currencys','salestax','customer_states','ship_state','currency','vendors','ExpenseAccounts','bill','billsItems'));

    }

    public function duplicateStore(Request $request)
    {
        $request->validate([
            'sale_vendor_id' => 'required|integer',
            'sale_bill_number' => 'required|string|max:255',
            'sale_bill_customer_ref' => 'nullable|string|max:255',
            'sale_bill_date' => 'required|date',
            'sale_bill_valid_date' => 'required|date',
            'sale_currency_id' => 'nullable|numeric',
            'sale_bill_sub_total' => 'required|numeric',
            'sale_bill_tax_amount' => 'required|numeric',
            'sale_bill_final_amount' => 'required|numeric',
            'sale_bill_note' => 'nullable|string',
            'sale_status' => 'required|integer',
            'sale_bill_status' => 'required|integer',
            'items.*.sale_product_id' => 'required|integer',
            'items.*.sale_bill_item_desc' => 'required|string',
            'items.*.sale_expense_id' => 'required|string',
            'items.*.sale_bill_item_qty' => 'required|integer|min:1',
            'items.*.sale_bill_item_price' => 'required|numeric|min:0',
            'items.*.sale_bill_item_tax' => 'required|integer',
        ], [
            'sale_vendor_id.required' => 'Please select a vendor.',
            'sale_vendor_id.integer' => 'Please select a vendor.',
            'sale_bill_number.required' => 'The bill number is required.',
            'sale_bill_date.required' => 'Please select the bill date.',
            'sale_bill_valid_date.required' => 'Please select the valid until date.',
            'sale_bill_sub_total.required' => 'Please enter the sub-total amount.',
            'sale_bill_tax_amount.required' => 'Please enter the tax amount.',
            'sale_bill_final_amount.required' => 'Please enter the final amount.',
            'sale_bill_image.image' => 'The file uploaded must be a valid image.',
            'sale_status.required' => 'Please set the status of the bill.',
            'sale_bill_status.required' => 'Please set the bill status.',
            'items.*.sale_product_id.integer' => 'Each item must have a product selected.',
            'items.*.sale_expense_id.integer' => 'Each item must have a expense category selected.',
            'items.*.sale_bill_item_desc.required' => 'Please provide a description for each item.',
            'items.*.sale_bill_item_qty.required' => 'Please enter the quantity for each item.',
            'items.*.sale_bill_item_qty.min' => 'The quantity for each item must be at least 1.',
            'items.*.sale_bill_item_price.required' => 'Please enter the price for each item.',
            'items.*.sale_bill_item_price.min' => 'The price for each item must be at least 0.',
            'items.*.sale_bill_item_tax.required' => 'Please select the tax amount for each item.',
        ]);
        // \DB::enableQueryLog();


        $bill = new Bills();
       
        $bill->fill($request->only([
            'sale_vendor_id', 'sale_bill_number','sale_bill_customer_ref', 'sale_bill_date', 'sale_bill_valid_date',  'sale_currency_id','sale_bill_sub_total', 'sale_bill_tax_amount','sale_bill_final_amount', 'sale_bill_note', 'sale_status', 'sale_bill_status'
        ]));
        $user = Auth::guard('masteradmins')->user();
        $bill->sale_currency_id = $request->sale_currency_id;
        $bill->sale_bill_paid_amount = 0;
        $bill->sale_bill_due_amount = $request->sale_bill_final_amount;
        $bill->id = $user->id;
        $bill->sale_status = 'Unpaid';
        // dd($estimate);
        $bill->save();

        foreach ($request->input('items') as $item) {
            $billItem = new BillsItems();
            
            $billItem->fill($item);

            $billItem->id = $user->id;
            $billItem->sale_bill_id = $bill->id; 
            $billItem->sale_bill_item_status = 1;

            $billItem->save();
        }
        // dd(\DB::getQueryLog()); 
        \MasterLogActivity::addToLog('Bill is Duplicate');

        session()->flash('bill-add', __('messages.masteradmin.bill.send_success'));
        return response()->json([
            'redirect_url' => route('business.bill.index'),
            'message' => __('messages.masteradmin.bill.send_success')
        ]);

    }


    
    
}
