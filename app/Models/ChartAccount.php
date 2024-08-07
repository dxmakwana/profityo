<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChartAccount extends Model
{
    use HasFactory;
       protected $fillable = [
        'id',
        'type_id',
        'acc_type_id',
        'chart_acc_name',
        'currency_id',
        'chart_account_id',
        'sale_acc_desc',
        'sale_product_status',
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_chart_account');
    }
}
