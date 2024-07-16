<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;
    public $table = "py_user_access";

    protected $fillable = [
        'sp_id',
        'mname',
        'mtitle',
        'mid',
        'is_access'
    ];

    public function adminmenu()
    {
        return $this->hasMany(AdminMenu::class, 'pmenu');
    }

}
