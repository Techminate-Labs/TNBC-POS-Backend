<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//Models
use App\Models\Invoice;

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

    public function dateViewChart($payment_method){
        return DB::table('invoices')
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
    }

    public function dayViewChart($payment_method){
        return DB::table('invoices')
        ->select(
            DB::raw("DATE_FORMAT(date,'%Y-%m-%d') as day"),
            DB::raw('sum(total) as total'),
        )
        ->where('payment_method', $payment_method)
        ->whereYear('date', Carbon::now()->year)
        ->where('date', '>', Carbon::today()->subDay(6))
        ->groupBy('day')
        ->orderBy('date', 'asc')
        ->get();
    }

    public function monthViewChart($payment_method){
        return Invoice::all();
    }

    public function backup($payment_method){
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