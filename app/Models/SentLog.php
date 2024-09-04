<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class SentLog extends Model
{
    use HasFactory;
    protected $fillable = ['id','tax_name', 'tax_abbreviation', 'tax_number', 'tax_desc', 'tax_number_invoices', 'tax_recoverable', 'tax_compound', 'tax_rate','tax_status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_sent_log');
    }

}
