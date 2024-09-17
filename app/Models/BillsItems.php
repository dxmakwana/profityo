<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BillsItems extends Model
{
    use HasFactory;

    protected $fillable = ['id','sale_bill_id', 'sale_product_id', 'sale_expense_id', 'sale_bill_item_qty', 'sale_bill_item_price', 'sale_bill_item_tax', 'sale_bill_item_desc', 'sale_bill_item_status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_bills_items');
    }
    public function bill_product()
    {
        return $this->belongsTo(PurchasProduct::class, 'sale_product_id','purchases_product_id');
    }

    public function item_tax()
    {
        return $this->belongsTo(SalesTax::class, 'sale_bill_item_tax','tax_id');
    }

    public function expense_category()
    {
        return $this->belongsTo(ChartAccount::class, 'sale_expense_id','chart_acc_id');
    }

}
