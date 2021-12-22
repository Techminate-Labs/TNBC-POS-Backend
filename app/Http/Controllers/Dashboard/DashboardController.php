<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Invoice;

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

    public function currentMonthSalesChart(Request $request)
    {
        return $this->graphServices->currentMonthSalesChart($request);
    }

    public function currentWeekSalesChart(Request $request)
    {
        return $this->graphServices->currentWeekSalesChart($request);
    }

    public function currentYearSalesChart(Request $request)
    {
        return $this->graphServices->currentYearSalesChart($request);
    }
}
