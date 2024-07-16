<?php

namespace App\Helpers;
use Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivities as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject)
    {	
		$user = Auth::user();
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
}