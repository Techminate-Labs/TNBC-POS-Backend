<?php
namespace App\Utilities;
use Request;

//Models
use App\Models\ActivityLog;

class ActivityLogServices
{
    public static function addToLog($subject)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	ActivityLog::create($log);
    }

    public static function logActivityLists()
    {
    	return ActivityLog::latest()->get();
    }
}