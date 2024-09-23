<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecurringInvoicesSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['id','sale_re_inv_id','repeat_inv_type','repeat_inv_month', 'repeat_inv_day','repeat_inv_date','invoice_date','create_inv_type', 'create_inv_number','create_inv_date','re_inv_sch_status'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_re_invoices_schedule');
    }
}
