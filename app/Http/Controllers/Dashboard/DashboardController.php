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

    public function testData1(Request $request){
        $payment_method = $request->payment_method;
        $sales = Invoice::
        where('payment_method', $payment_method)
        ->whereYear('date', Carbon::now()->year)
        ->orderBy('date', 'asc')
        ->get();

        $data = [];
        foreach($sales as $sale) {
            // $store = strtotime($sale->date);
            // return date('Y-m-d',$store);
            $data['label'][] = $sale->created_at;
            $data['total'][] = (int)$sale->total;
        }
        return $data;
    }

    public function testData2(Request $request){
        $payment_method = $request->payment_method;
        $sales = DB::table('invoices')
        ->select(
            DB::raw("DATE_FORMAT(date,'%Y-%m-%d') as months"),
            DB::raw('sum(total) as total'),
        )
        ->where('payment_method', $payment_method)
        ->whereYear('date', Carbon::now()->year)
        ->whereMonth('date', Carbon::now()->month)
        ->groupBy('months')
        ->orderBy('date', 'asc')
        ->get();

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = strtotime($sale->months);
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }
}
