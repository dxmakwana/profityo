<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAdminLogActivities extends Model
{
    use HasFactory;
    protected $fillable = ['subject', 'url', 'method', 'ip', 'agent', 'user_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (\Auth::guard('masteradmins')->check()) {
            $user = \Auth::guard('masteradmins')->user();
            $uniq_id = $user->buss_unique_id;
            $this->setTable($uniq_id . '_py_log_activities_table'); // Set the table for master admin logs
        }
    }
}
