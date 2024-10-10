<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Countries;
use App\Models\States;
use App\Models\Employees;
use App\Models\EmployeeTaxDetails;

use App\Models\EmployeeComperisation;
use App\Models\EmployeeStartOffboarding;
use App\Models\EmployeePlaceLeave;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    //
    public function index(): View
    {
        $employees = Employees::all(); // This will fetch all employees, adjust the query if needed

    // Pass the employee data to the view
    return view('masteradmin.payroll_employee.index', compact('employees'));
    }
    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        $State = States::all(); // Fetch all states
        return view('masteradmin.payroll_employee.add', compact('Country', 'State'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('masteradmins')->user();
    
        // Validate request data
        $request->validate([
            'emp_first_name' => 'required|string|max:255',
            'emp_last_name' => 'nullable|string|max:255',
            'emp_social_security_number' => 'required|string|max:255',
            'emp_hopy_address' => 'nullable|string|max:255',
            'city_name' => 'nullable|string|max:255',
            'state_id' => 'nullable|numeric',
            'zipcode' => 'nullable|string|max:255',
            'emp_dob' => 'required|string|max:255',
            'emp_email' => 'nullable|email|max:255',
            // 'emp_middle_initial' => 'nullable|string|max:255',
            'emp_doh' => 'required|string|max:255',
            'emp_work_location' => 'required|string|max:255',
            'emp_wage_type' => 'required|string|max:255',
            'emp_wage_amount' => 'required|string|max:255',
            'emp_status' => 'nullable|string|max:255',
        ],[
            'emp_first_name.required' => 'The first name field is required.',
            'emp_last_name.required' => 'The last name field is required.',
            'emp_social_security_number.required' => 'The social security number field is required.',
            'emp_wage_amount.required' => 'The wage amount field is required.',
        ]);
    
        // Prepare the data for insertion
        $validatedData = $request->all();
        $validatedData['id'] = $user->id; // Use the correct field name for user ID
        $validatedData['emp_status'] = 1;
    
        // Insert the data into the Employees table
        Employees::create([
            'emp_first_name' => $validatedData['emp_first_name'],
            'emp_last_name' => $validatedData['emp_last_name'],
            'emp_social_security_number' => $validatedData['emp_social_security_number'],
            'emp_hopy_address' => $validatedData['emp_hopy_address'],
            'city_name' => $validatedData['city_name'],
            'state_id' => $validatedData['state_id'],
            'zipcode' => $validatedData['zipcode'],
            'emp_dob' => $validatedData['emp_dob'],
            'emp_email' => $validatedData['emp_email'],
            // 'emp_middle_initial' => $validatedData['emp_middle_initial'],
            'emp_doh' => $validatedData['emp_doh'],
            'emp_work_location' => $validatedData['emp_work_location'],
            'emp_wage_type' => $validatedData['emp_wage_type'],
            'emp_wage_amount' => $validatedData['emp_wage_amount'],
            'id' => $validatedData['id'],
            'emp_status' => $validatedData['emp_status'],
        ]);
    
        return redirect()->route('business.employee.index')->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
    }
    

    public function edit($id): View
{

    // dd('hiii');
    // Fetch employee data by ID
    $employee = Employees::where('emp_id' , $id)->firstOrFail();
// dd($employee);
    // Fetch countries and states for dropdowns
    $Country = Countries::all(); 
    $State = States::all(); 

    return view('masteradmin.payroll_employee.edit', compact('employee', 'Country', 'State'));
}
public function update(Request $request, $id)
{
  
    $user = Auth::guard('masteradmins')->user();

    // Dynamically create the table name based on the user ID
    $dynamicId = $user->user_id; 
    $tableName = $dynamicId . '_py_employees'; 

    // Validate request data
    $validatedData = $request->validate([
        'emp_first_name' => 'required|string|max:255',
        'emp_last_name' => 'nullable|string|max:255',
        'emp_social_security_number' => 'nullable|string|max:255',
        'emp_hopy_address' => 'nullable|string|max:255',
        'city_name' => 'nullable|string|max:255',
        'state_id' => 'nullable|numeric',
        'zipcode' => 'nullable|string|max:255',
        'emp_dob' => 'nullable|string|max:255',
        'emp_email' => 'nullable|email|max:255',
        'emp_doh' => 'nullable|string|max:255',
        'emp_work_location' => 'nullable|string|max:255',
        'emp_wage_type' => 'nullable|string|max:255',
        'emp_wage_amount' => 'nullable|string|max:255',
    ]);

    // Find the employee record by ID in the dynamic table
    $employee = Employees::where('emp_id' , $id)->first();

    if (!$employee) {
        return redirect()->route('business.employee.index')->withErrors('Employee not found.');
    }

    // Update the employee record
    Employees::where('emp_id', $id)->update([
        'emp_first_name' => $request->emp_first_name,
        'emp_last_name' => $request->emp_last_name,
        'emp_social_security_number' => $request->emp_social_security_number,
        'emp_hopy_address' => $request->emp_hopy_address,
        'city_name' => $request->city_name,
        'state_id' => $request->state_id,
        'zipcode' => $request->zipcode,
        'emp_dob' => $request->emp_dob,
        'emp_email' => $request->emp_email,
        'emp_doh' => $request->emp_doh,
        'emp_work_location' => $request->emp_work_location,
        'emp_wage_type' => $request->emp_wage_type,
        'emp_wage_amount' => $request->emp_wage_amount,
    ]);

    return redirect()->route('business.employee.index')->with(['employee-edit' => __('messages.masteradmin.employee.edit_success')]);
}




public function storeCompensation(Request $request, $id)
{
    ///dd($request->all());
    // Get the authenticated user
    $user = Auth::guard('masteradmins')->user();
    
    // Find the employee using the provided emp_id and ensure the correct table prefix
    $employee = Employees::where('emp_id', $id)->firstOrFail(); // Using $id directly

    // Validate compensation form fields
    $request->validate([
        'emp_comp_salary_amount' => 'required|numeric',
        'emp_comp_salary_type' => 'required|string',
        'effective_date' => 'required|string', // Uncomment if needed
    ], [
        'emp_comp_salary_amount.required' => 'The salary amount is required.',
        'emp_comp_salary_type.required' => 'Please select a salary type.',
        'effective_date.required' => 'Please provide an effective date.',
    ]);

    // Insert the compensation data into the EmployeeComperisation model
   $dx = EmployeeComperisation::create([
        'emp_id' => $id,  // Store the emp_id directly
        'id' => $user->id,  // Assuming you're storing the user ID
        'emp_comp_salary_amount' => $request->emp_comp_salary_amount,
        'emp_comp_salary_type' => $request->emp_comp_salary_type,
        'emp_comp_effective_date' => $request->emp_comp_effective_date, // Uncomment if needed
        'emp_comp_status' => 1,  // Set to active or any status you prefer
    ]);

    // dd($dx);

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

public function storeTaxDetails(Request $request, $emp_id)
{
    $user = Auth::guard('masteradmins')->user();

    // Validate the form data
    $request->validate([
        'emp_tax_deductions' => 'required|numeric',
        'emp_tax_dependent_amount' => 'required|numeric',
        'emp_tax_filing_status' => 'required|string',
        'emp_tax_nra_amount' => 'required|numeric',
        'emp_tax_other_income' => 'required|numeric',
        'emp_tax_job' => 'required|numeric',
        'emp_tax_california_total_allowances' => 'required|numeric',
        'emp_tax_california_filing_status' => 'required|string',

        // Add other validation rules for tax details
    ]);
   
    // Prepare data for insertion
    $taxDetails = [
        // 'emp_id' => $id,  // Store the emp_id directly
        'id' => $user->id,
        'emp_id' => $emp_id,  // Employee ID
        'emp_tax_deductions' => $request->emp_tax_deductions,
        'emp_tax_dependent_amount' => $request->emp_tax_dependent_amount,
        'emp_tax_filing_status' => $request->emp_tax_filing_status,
        'emp_tax_nra_amount' => $request->emp_tax_nra_amount,
        'emp_tax_other_income'=> $request->emp_tax_other_income,
        'emp_tax_job'=> $request->emp_tax_job,
        'emp_tax_california_state_tax'=> $request->emp_tax_california_state_tax,
        'emp_tax_california_filing_status'=> $request->emp_tax_california_filing_status,
        'emp_tax_california_total_allowances'=> $request->emp_tax_california_total_allowances,
        'emp_tax_non_resident_emp'=> $request->emp_tax_non_resident_emp,
        'emp_tax_california_state'=> $request->emp_tax_california_state,
        'emp_tax_california_sdi'=> $request->emp_tax_california_sdi,
        // Add other tax fields here
        'emp_tax_status' => 1,  // Set tax status to active or any other status
    ];

    // Insert the tax details into the dynamic table
    EmployeeTaxDetails::create($taxDetails);

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}
// app/Http/Controllers/Masteradmin/EmployeesController.php

public function storeOffboarding(Request $request, $emp_id)
{
    // dd('aaa');
    // Get the authenticated user
    $user = Auth::guard('masteradmins')->user();
    
    // Validate request data
    $request->validate([
        'emp_off_ending' => 'required|string',
        'emp_off_last_work_date' => 'required|date',
        'emp_off_notice_date' => 'nullable|date',
    ]);

    // Prepare the data for insertion
    $offboardingData = [
        'emp_id' => $emp_id,  
        'id' => $user->id, 
        'ct_id' => $user->ct_id, 
        'emp_off_ending' => $request->emp_off_ending,
        'emp_off_last_work_date' => $request->emp_off_last_work_date,
        'emp_off_notice_date' => $request->emp_off_notice_date,
        'emp_off_status' =>1,
    ];
    // dd($offboardingData);

   
    EmployeeStartOffboarding::create($offboardingData);

    // Redirect back with success message
    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}
// app/Http/Controllers/Masteradmin/EmployeesController.php

public function storeLeaveData(Request $request, $emp_id)
{
    // Validation and data insertion as described in your code
    $request->validate([
        'emp_lev_desc' => 'nullable|string',
    ]);

    $user = Auth::guard('masteradmins')->user();

    $offboardingData = [
        'emp_id' => $emp_id,    // Use the passed emp_id
        'id' => $user->id,
        'ct_id' => $user->ct_id, 
        'emp_lev_desc' => $request->emp_lev_desc,
        'emp_lev_end_date' => $request->emp_lev_end_date,
        'emp_lev_start_date' => $request->emp_lev_start_date,
        'emp_lev_status' => 1,
    ];

    EmployeePlaceLeave::create($offboardingData);

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

public function destroy($emp_id)
{
    // Find the employee by emp_id
    // dd($emp_id);
    $employee = Employees::where('emp_id', $emp_id)->first();

    if (!$employee) {
        return redirect()->route('business.employee.index')->withErrors('Employee not found.');
    }

    // Delete related data from all other tables
    EmployeeTaxDetails::where('emp_id', $emp_id)->delete();
    EmployeeComperisation::where('emp_id', $emp_id)->delete();
    EmployeeStartOffboarding::where('emp_id', $emp_id)->delete();
    EmployeePlaceLeave::where('emp_id', $emp_id)->delete();

    // Delete the employee record
    $employee->where('emp_id', $emp_id)->delete();

    return redirect()->route('business.employee.index')->with('delete_success', __('messages.masteradmin.employee.delete_success'));
}


}
