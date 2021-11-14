<?php

namespace App\Services\System;

//Service
use App\Services\BaseServices;

//Interface

//Models

class ActivityLogServices extends BaseServices{
    public function logList($request)
    {
        $this->logCreate($request);
        return $this->baseRI->listWithPagination($this->logModel, $request->limit);
    }
}