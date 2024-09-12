<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class RecurringInvoicesItems extends Model
{
    use HasFactory;

    protected $fillable = ['id','sale_re_inv_id','sale_product_id','sale_re_inv_item_qty', 'sale_re_inv_item_price','sale_re_inv_item_discount','sale_re_inv_item_tax','sale_re_inv_item_desc', 'sale_re_inv_item_amount','sale_re_inv_item_status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_inv_recurring_items');
    }

    public function invoices_product()
    {
        return $this->belongsTo(SalesProduct::class, 'sale_product_id','sale_product_id');
    }

    public function item_tax()
    {
        return $this->belongsTo(SalesTax::class, 'sale_re_inv_item_tax','tax_id');
    }
}
