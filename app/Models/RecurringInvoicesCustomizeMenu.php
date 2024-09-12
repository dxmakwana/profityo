<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecurringInvoicesCustomizeMenu extends Model
{
    use HasFactory;

    protected $fillable = ['sale_inv_id','id','mname', 'mtitle', 'mid', 'is_access', 'inv_cust_menu_title'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_customize_menu_invoices');
    }

}
