<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BusinessDetails extends Model
{
    use HasFactory;
    protected $fillable = ['id','bus_company_name', 'bus_image', 'state_id', 'country_id', 'city_name', 'zipcode', 'bus_address1', 'bus_address2', 'bus_phone', 'bus_mobile', 'bus_website', 'bus_currency', 'bus_status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_business_details');
    }
}
