<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;
    public $table = "py_countries";
    
    public function states()
    {
        return $this->hasMany(States::class);
    }

    public function currency()
    {
        return $this->belongsTo(Estimates::class, 'sale_currency_id', 'id');
    }

    public function invoice_currency()
    {
        return $this->belongsTo(InvoicesDetails::class, 'sale_currency_id', 'id');
    }


}
