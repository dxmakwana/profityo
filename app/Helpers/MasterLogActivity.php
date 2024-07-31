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
        if (!$user) {
            return; // Handle cases where the user is not authenticated
        }
        // dd($user);
        // Create an instance of MasterAdminLogActivities
        $logActivityModel = new MasterLogActivityModel();
        // Set the table name for this user's logs
        $logActivityModel->setTableForUniqueId($user->user_id);

        $log = [
            'subject' => $subject,
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'ip' => Request::ip(),
            'agent' => Request::header('user-agent'),
            'user_id' => $user->users_id,
        ];

        // Create the log entry
        $logActivityModel->create($log);
    }

    public static function logActivityLists()
    {
        $user = Auth::guard('masteradmins')->user();
        if (!$user) {
            return collect(); // Handle cases where the user is not authenticated
        }

        $logActivityModel = new MasterLogActivityModel();
        $logActivityModel->setTableForUniqueId($user->user_id);

        return $logActivityModel->latest()->get();
    }

    public static function deleteOldLogs()
    {
        $user = Auth::guard('masteradmins')->user();
        if (!$user) {
            return; // Handle cases where the user is not authenticated
        }

        $thresholdDate = Carbon::now()->subDay()->toDateTimeString();

        // Set up the log activity model
        $logActivityModel = new MasterLogActivityModel();
        $logActivityModel->setTableForUniqueId($user->user_id);

        // Delete log entries older than the threshold date
        $deleted = $logActivityModel->where('created_at', '<', $thresholdDate)->delete();
    }
}