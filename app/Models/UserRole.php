<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['id','role_name', 'role_status'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->buss_unique_id;
        $this->setTable($uniq_id . '_py_users_role');
    }
}
