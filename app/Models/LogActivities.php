<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivities extends Model
{
    use HasFactory;
    protected $table = 'log_activities_table';
    protected $fillable = ['subject', 'url', 'method', 'ip', 'agent', 'user_id'];

}
