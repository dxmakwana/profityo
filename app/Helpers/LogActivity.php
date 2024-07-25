<?php

namespace App\Helpers;
use Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\LogActivities as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject)
    {	
        if (Auth::guard('masteradmins')->check()) {
            $user = Auth::guard('masteradmins')->user();
        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } else {
            // Handle case where no user is authenticated
            return;
        }

		
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = $user->id;
    	LogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }

	public static function deleteOldLogs()
    {
        // Define your threshold date (1 day ago)
        $thresholdDate = Carbon::now()->subDay()->toDateTimeString();

        // Log the threshold date for debugging
        \Log::info('Deleting logs older than: ' . $thresholdDate);

        // Delete log entries older than the threshold date
        $deleted = LogActivityModel::where('created_at', '<', $thresholdDate)->delete();

        // Log the number of deleted entries
        \Log::info('Deleted ' . $deleted . ' old log entries.');
    }
}