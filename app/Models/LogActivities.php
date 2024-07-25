<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogActivities extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'url', 'method', 'ip', 'agent', 'user_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Check if the user is authenticated with the 'masteradmins' guard
        if (Auth::guard('masteradmins')->check()) {
            $user = Auth::guard('masteradmins')->user();
            $uniq_id = $user->buss_unique_id;
            $this->setTable($uniq_id . '_py_log_activities_table');
        }
        // Check if the user is authenticated with the 'web' guard
        elseif (Auth::guard('web')->check()) {
            $this->setTable('log_activities_table');
        }
    }

}
