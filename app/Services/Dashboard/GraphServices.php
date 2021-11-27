<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

//Service
use App\Services\BaseServices;

class GraphServices extends BaseServices{

    private $brandModel = Invoice::class;

    public function monthlySalesChart()
    {
        $invoiceTable = 'invoices';

        $sales = DB::table($invoiceTable)->select(
                            DB::raw("DATE_FORMAT(date,'%D-%b') as months"),
                            DB::raw('sum(total) as total'),
                        )
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->groupBy('months')
                        ->orderBy('date', 'desc')
                        ->get();

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->months;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function dayChart()
    {
        $invoiceTable = 'invoices';
        $sales = DB::table($invoiceTable)->select(
                            DB::raw("DAYNAME(date) as day_name"),
                            DB::raw("DAY(date) as day"),
                            DB::raw('sum(total) as total'),
                        )
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->where('date', '>', Carbon::today()->subDay(6))
                        ->groupBy('day_name','day')
                        ->orderBy('day', 'desc')
                        ->get();

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->day_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }
}