<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'sale_cus_id',
        'cus_con_name',
        'cus_con_email',
        'cus_con_phone',
        'cus_con_status',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        // $userDetails = session('user_details');
        // Auth::guard('masteradmins')->setUser($userDetails);

        
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_sale_customer_contact');
    }

}
