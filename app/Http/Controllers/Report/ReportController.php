<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Report\ReportServices;

class ReportController extends Controller
{
    private $reportServices;

    public function __construct(ReportServices $reportServices){
        $this->services = $reportServices;
    }

    public function report(Request $request)
    {
        return $this->services->report($request);
    }
}
