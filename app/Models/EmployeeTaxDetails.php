<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeTaxDetails extends Model
{
    use HasFactory;
    protected $fillable = ['emp_id','id',
    'emp_tax_deductions',
    'emp_tax_dependent_amount',
    'emp_tax_filing_status',
    'emp_tax_nra_amount',
    'emp_tax_other_income',
    'emp_tax_job',
    'emp_tax_california_state_tax',
    'emp_tax_california_filing_status',
    'emp_tax_california_total_allowances',
    'emp_tax_non_resident_emp',
    'emp_tax_california_state',
    'emp_tax_california_sdi',
    'emp_tax_status'
];
   
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_employee_tax_details');
    }
}
