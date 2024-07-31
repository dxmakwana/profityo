<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAdminLogActivities extends Model
{
    use HasFactory;
    protected $fillable = ['subject', 'url', 'method', 'ip', 'agent', 'user_id'];

    public function setTableForUniqueId($uniqueId)
    {
        $this->setTable($uniqueId . '_py_log_activities_table');
    }
}
