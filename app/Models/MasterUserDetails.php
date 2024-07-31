<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class MasterUserDetails extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['id','users_name', 'users_email', 'users_phone', 'users_password', 'role_id','user_id','users_status'];

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);

    //     // Dynamically set the table name
    //     $user = Auth::guard('masteradmins')->user();
    //     $uniq_id = $user->buss_unique_id;
    //     $this->setTable($uniq_id . '_py_users_details');
    // }
    
    public function setTableForUniqueId($uniqueId)
    {
        $this->setTable($uniqueId . '_py_users_details');
    }
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'role_id');
    }

    protected $hidden = [
        'users_phone',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'users_password' => 'hashed',
    ];

}
