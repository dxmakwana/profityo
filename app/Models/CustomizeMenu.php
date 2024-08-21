<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizeMenu extends Model
{
    use HasFactory;
    public $table = "py_customize_menu";
    //INSERT INTO `py_customize_menu`(`cust_menu_id`, `mname`, `mtitle`, `sub_title`, `pmenu`, `cust_menu_status`, `created_at`, `updated_at`) 
    protected $fillable = [
        'mname',
        'mtitle',
        'sub_title',
        'pmenu',
    ];

    public function parent()
    {
        return $this->belongsTo(CustomizeMenu::class, 'pmenu', 'cust_menu_id');
    }

    // Children relationship
    public function children()
    {
        return $this->hasMany(CustomizeMenu::class, 'pmenu', 'cust_menu_id');
    }

    // Accessor to get the parent menu title
    public function getParentMenuTitleAttribute()
    {
        return $this->parent ? $this->parent->mtitle : $this->mtitle;
    }

}
