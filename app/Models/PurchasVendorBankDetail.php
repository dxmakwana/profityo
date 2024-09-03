<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchasVendorBankDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'id',
        // 'purchases_vendor_id',
        // 'purchases_routing_number',
        // 'purchases_account_number',
        // 'bank_account_type',
        'purchases_vendor_id',
        'purchases_routing_number',
        'purchases_account_number',
        'bank_account_type',
        'id',
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_purchases_bank_details');
    }
    public function vendor()
    {
        return $this->belongsTo(PurchasVendor::class, 'purchases_vendor_id','purchases_vendor_id');
    }
}
