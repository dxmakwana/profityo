<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterUserDetails extends Model
{
    use HasFactory;
    protected $fillable = ['id','users_name', 'users_email', 'users_phone', 'users_password', 'role_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->buss_unique_id;
        $this->setTable($uniq_id . '_py_users_details');
    }
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'role_id');
    }
}
