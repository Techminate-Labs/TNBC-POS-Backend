<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
// use App\Services\System\ActivityLogServices;

//Models
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    // private $configServices;

    public function __construct(){
        $this->fullURL = Request::fullUrl();
    }

    public function logCreate()
    {
        // return $this->services->addToLog('Test');
        $subject = 'test';
        $log = [];
    	$log['subject'] = $subject;
    	$log['url'] = $this->fullURL;
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	ActivityLog::create($log);
    }

}
