<?php

namespace App\Services\System;

//Service
use App\Services\BaseServices;

class ActivityLogServices extends BaseServices{
    public function logList($request)
    {
        $this->logCreate($request);
        return $this->baseRI->listWithPagination($this->logModel, $request->limit);
    }
}