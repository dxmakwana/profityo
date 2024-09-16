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
        $query = Bills::with('vendor')->orderBy('created_at', 'desc');

        // if ($request->has('start_date') && $request->start_date) {
        //     $query->whereDate('sale_estim_date', '>=', $request->start_date);
        // }

        // if ($request->has('end_date') && $request->end_date) {
        //     $query->whereDate('sale_estim_date', '<=', $request->end_date);
        // }

        if ($startDate) {

            $query->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);

        }
    
        if ($endDate) {
            $query->whereRaw("STR_TO_DATE(sale_estim_valid_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);

        }

        if ($request->has('sale_estim_number') && $request->sale_estim_number) {
            $query->where('sale_estim_number', 'like', '%' . $request->sale_estim_number . '%');
        }

        if ($request->has('sale_cus_id') && $request->sale_cus_id) {
            $query->where('sale_cus_id', $request->sale_cus_id);
        }

        if ($request->has('sale_status') && $request->sale_status) {
            $query->where('sale_status', $request->sale_status);
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

    public function create(): View
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

        
        $salestax = SalesTax::all();

        $vendors = PurchasVendor::where('id', $user->id)->first();

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
        if ($vendors && $vendors->sale_bill_country_id) {
            $customer_states = States::where('country_id', $vendors->purchases_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($vendors && $vendors->sale_ship_country_id) {
            $ship_state = States::where('country_id', $vendors->purchases_ship_country_id)->get();
        }



        // dd($businessDetails);
        return view('masteradmin.bills.add', compact('salevendor','products','currencys','salestax','specificMenus','HideMenus','HideSettings','HideDescription','customer_states','ship_state','currency','vendors'));
    }

}
