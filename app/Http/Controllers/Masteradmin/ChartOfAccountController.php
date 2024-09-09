<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Add this to use DB facade
use Illuminate\View\View;
use App\Models\Countries;
use App\Models\ChartAccount;



class ChartOfAccountController extends Controller
{
//     public function index(): View
//     {
//         // Fetch data categorized by 'menu_id'
//         $assets = DB::table('py_chart_account_menu')
//         ->where('menu_id', 3) // Assuming '3' corresponds to 'Assets'
//         ->where('chart_menu_status', 1)
//         ->get();

//         $expenses = DB::table('py_chart_account_menu')
//         ->where('menu_id', 1) // Assuming '3' corresponds to 'expenses'
//         ->where('chart_menu_status', 1)
//         ->get();
// // dd($assets);
//         $liabilitiesAndCreditCards = DB::table('py_chart_account_menu')
//         ->where('menu_id', 2)  // Assuming '2' corresponds to 'Liabilities and Credit Cards'
//         ->where('chart_menu_status', 1)
//         ->get();
//             // dd($liabilitiesAndCreditCards);

//         $income = DB::table('py_chart_account_menu')
//         ->where('menu_id', 4)  // Assuming '4' corresponds to 'Income'
//         ->where('chart_menu_status', 1)
//         ->get();
//         // dd($income);
//         $equity = DB::table('py_chart_account_menu')
//         ->where('menu_id', 5) // Assuming '3' corresponds to 'equity'
//         ->where('chart_menu_status', 1)
//         ->get();
//         // Pass the data to the view
//         return view('masteradmin.chartofaccount.index', compact('assets','liabilitiesAndCreditCards','income','equity','expenses'));
//     }




public function index(): View
{
    // Fetch data categorized by 'menu_id'
    $Country = Countries::all();
    $assets = DB::table('py_chart_account_menu')
        ->where('menu_id', 3) // Assets
        ->where('chart_menu_status', 1)
        ->get();

    $liabilitiesAndCreditCards = DB::table('py_chart_account_menu')
        ->where('menu_id', 2)  // Liabilities and Credit Cards
        ->where('chart_menu_status', 1)
        ->get();

    $income = DB::table('py_chart_account_menu')
        ->where('menu_id', 4)  // Income
        ->where('chart_menu_status', 1)
        ->get();

    $equity = DB::table('py_chart_account_menu')
        ->where('menu_id', 5) // Equity
        ->where('chart_menu_status', 1)
        ->get();

    $expenses = DB::table('py_chart_account_menu')
        ->where('menu_id', 1) // Expenses
        ->where('chart_menu_status', 1)
        ->get();

    // Pass the data to the view
    return view('masteradmin.chartofaccount.index', compact('assets', 'liabilitiesAndCreditCards', 'income', 'equity', 'expenses','Country'));
}


public function store(Request $request)
{
    // dd($request);
    $user = Auth::guard('masteradmins')->user(); // Get the authenticated user
    $validatedData = $request->validate([
        // 'type_id' => 'required|integer',
        'acc_type_id' => 'nullable|integer',
        'chart_acc_name' => 'nullable|string|max:255',
        'currency_id' => 'nullable|integer',
        'chart_account_id' => 'nullable|string|max:255',
        'sale_acc_desc' => 'nullable|string|max:255',
        // 'sale_product_status' => 'required|boolean',
    ], [
        'acc_type_id.required' => 'The account type field is required.',
        'chart_acc_name.required' => 'The account name field is required.',
        'currency_id.required' => 'The currency field is required.',
    ]);
    $validatedData['id'] = $user->id; 
    $validatedData['sale_product_status'] = 1; 
    $query = DB::table('py_chart_account_menu')
        ->where('chart_menu_id',$request->acc_type_id) // Assets
        ->where('chart_menu_status', 1)
        ->first();
        // dd($query);
        $validatedData['type_id'] = $query->menu_id; 
    ChartAccount::create($validatedData);

    return redirect()->back()->with('success', 'Account created successfully.');
}

}
