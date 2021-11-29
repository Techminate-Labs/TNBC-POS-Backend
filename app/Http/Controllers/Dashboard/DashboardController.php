<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Dashboard\CountServices;
use App\Services\Dashboard\GraphServices;

class DashboardController extends Controller
{
    private $countServices;
    private $graphServices;

    public function __construct(
        CountServices $countServices,
        GraphServices $graphServices
    ){
        $this->countServices = $countServices;
        $this->graphServices = $graphServices;
    }

    public function countTotal()
    {
        return $this->countServices->countTotal();
    }

    public function dateViewChart(Request $request)
    {
        return $this->graphServices->dateViewChart($request);
    }

    public function dayViewChart(Request $request)
    {
        return $this->graphServices->dayViewChart($request);
    }

    public function monthViewChart(Request $request)
    {
        return $this->graphServices->monthViewChart($request);
    }
}
