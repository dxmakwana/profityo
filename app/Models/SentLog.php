<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class SentLog extends Model
{
    use HasFactory;
    protected $fillable = ['log_type','user_id', 'id', 'log_msg', 'status', 'log_status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_sent_log');
    }
//     public function invoice()
// {
//     return $this->belongsTo(InvoicesDetails::class, 'sale_inv_id');
public function estimate()
    {
        return $this->belongsTo(Estimates::class, 'id', 'sale_estim_id');
    }

    public function invoice()
    {
        return $this->belongsTo(InvoicesDetails::class, 'id', 'sale_inv_id');
    }
}


// }
