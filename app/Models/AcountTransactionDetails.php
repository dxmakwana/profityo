<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class AcountTransactionDetails extends Model
{
    use HasFactory;
       protected $fillable = [
        'id',
        'emp_id',
        'tax_id',
        'trans_tax_amount',
        'acc_trans_status',
    ];
    protected $primaryKey = 'acc_trans_id '; // Adjust if the primary key is different

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_acc_transaction_details');
    }
}
