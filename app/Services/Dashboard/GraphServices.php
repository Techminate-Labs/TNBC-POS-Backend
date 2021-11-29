<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

//Service
use App\Services\BaseServices;

class GraphServices extends BaseServices{

    private $brandModel = Invoice::class;

    public function dateViewChart($request)
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $payment_method = $request->payment_method;

        $sales = DB::table($invoiceTable)->select(
                            DB::raw("DATE_FORMAT(date,'%D-%b') as months"),
                            DB::raw('sum(total) as total'),
                        )
                        ->where($prop, $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->groupBy('months')
                        ->orderBy('date', 'asc')
                        ->get();

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->months;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function dayViewChart($request)
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $payment_method = $request->payment_method;
        
        $sales = DB::table($invoiceTable)->select(
                            DB::raw("DAYNAME(date) as day_name"),
                            DB::raw("DAY(date) as day"),
                            DB::raw('sum(total) as total'),
                        )
                        ->where($prop, $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->where('date', '>', Carbon::today()->subDay(6))
                        ->groupBy('day_name','day')
                        ->orderBy('day', 'asc')
                        ->get();

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->day_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function monthViewChart($request)
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $payment_method = $request->payment_method;

        $sales = DB::table($invoiceTable)->select(
                            DB::raw("MONTHNAME(date) as month_name"),
                            DB::raw("MONTH(date) as month"),
                            DB::raw('sum(total) as total'),
                        )
                        ->where($prop, $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->groupBy('month_name','month')
                        ->orderBy('month', 'asc')
                        ->get();

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->month_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }
}