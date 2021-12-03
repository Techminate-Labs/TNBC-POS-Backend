<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//Interface
use App\Contracts\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface{
    public function reportDay($payment_method, $limit, $year, $month, $day){
        return DB::table('invoices')
        ->where('payment_method', $payment_method)
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->whereDate('date', $day)
        ->orderBy('date', 'asc')
        ->paginate($limit);
    }

    public function reportWeek($payment_method, $limit, $year, $startOfTheWeek, $endOfTheWeek){
        return  DB::table('invoices')
        ->where('payment_method', $payment_method)
        ->whereYear('date', $year)
        ->whereBetween('date', [$startOfTheWeek, $endOfTheWeek])
        ->orderBy('date', 'asc')
        ->paginate($limit);
    }

    public function reportMonth($payment_method, $limit, $year, $month){
        return DB::table('invoices')
        ->where('payment_method', $payment_method)
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->orderBy('date', 'asc')
        ->paginate($limit);
    }

    public function reportYear($payment_method, $limit, $year){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', $year)
                        ->paginate($limit);
    }


}