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
        return 'ok';
    }

    public function monthlySalesChart()
    {
        return 'ok';
    }

    public function dayChart()
    {
        return 'ok';
    }
}
