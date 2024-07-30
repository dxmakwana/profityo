<?php

namespace App\Helpers;
use Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\MasterAdminLogActivities as MasterLogActivityModel;

class MasterLogActivity
{
    public static function addToLog($subject)
    {	

        $user = Auth::guard('masteradmins')->user();
		
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = $user->id;
    	MasterLogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
    	return MasterLogActivityModel::latest()->get();
    }

	public static function deleteOldLogs()
    {
        // Define your threshold date (1 day ago)
        $thresholdDate = Carbon::now()->subDay()->toDateTimeString();

        // Delete log entries older than the threshold date
        $deleted = MasterLogActivityModel::where('created_at', '<', $thresholdDate)->delete();
    }
}