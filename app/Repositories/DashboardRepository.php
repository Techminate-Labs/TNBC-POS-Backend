<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//Interface
use App\Contracts\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface{

    public function countData($table){
        return DB::table($table)->count();
    }

    public function countSales($payment_method){
        return DB::table('invoices')
        ->where('payment_method', $payment_method)
        ->count();
    }

    public function currentMonthSalesChart($payment_method){
        return DB::table('invoices')
        ->select(
            DB::raw("DATE_FORMAT(date,'%D-%b') as months"),
            DB::raw('sum(total) as total'),
        )
        ->where('payment_method', $payment_method)
        ->whereYear('date', Carbon::now()->year)
        ->whereMonth('date', Carbon::now()->month)
        ->groupBy('months')
        ->orderBy('date', 'asc')
        ->get();
    }

    public function currentWeekSalesChart($payment_method){
        return DB::table('invoices')
        ->select(
            DB::raw("DAYNAME(date) as day_name"),
            DB::raw("DAY(date) as day"),
            DB::raw('sum(total) as total'),
        )
        ->where('payment_method', $payment_method)
        ->whereYear('date', Carbon::now()->year)
        ->where('date', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day', 'asc')
        ->get();
    }

    public function currentYearSalesChart($payment_method){
        return DB::table('invoices')
        ->select(
            DB::raw("MONTHNAME(date) as month_name"),
            DB::raw("MONTH(date) as month"),
            DB::raw('sum(total) as total'),
        )
        ->where('payment_method', $payment_method)
        ->whereYear('date', Carbon::now()->year)
        ->groupBy('month_name','month')
        ->orderBy('month', 'asc')
        ->get();
    }
}