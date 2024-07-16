<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use HasFactory;
    public $table = "py_admin_menu";

    public function subPermissions()
    {
        return $this->hasMany(AdminMenu::class, 'pmenu');
    }
}
