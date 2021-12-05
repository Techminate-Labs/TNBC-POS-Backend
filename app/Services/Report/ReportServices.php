<?php

namespace App\Services\Report;

use Carbon\Carbon;

//Interface
use App\Contracts\ReportRepositoryInterface;

class ReportServices{
    private $reportRepositoryInterface;

    public function __construct(
        ReportRepositoryInterface $reportRepositoryInterface
    ){
        $this->reportRI = $reportRepositoryInterface;
        $this->year = Carbon::now()->year;
        $this->lastYear = Carbon::now()->subYear();
        $this->month = Carbon::now()->month;
        $this->lastMonth = Carbon::now()->subMonth();
        $this->yesterday = Carbon::today()->subDay();
        $this->today = Carbon::today();
        $this->nowWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $this->nowWeekEnd = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $this->lastWeekStart = Carbon::now()->subWeek(1)->startOfWeek();
        $this->lastWeekEnd = Carbon::now()->subWeek(1)->endOfWeek();    
    }
    
    //Day
    public function reportDay($payment_method, $limit, $day){
        return $this->reportRI->reportDay($payment_method, $limit, $this->year, $this->month, $day);
    }

    //Week
    public function reportWeek($payment_method, $limit, $startOfTheWeek, $endOfTheWeek){
        return $this->reportRI->reportWeek($payment_method, $limit, $this->year, $startOfTheWeek, $endOfTheWeek);
    }

    //Month
    public function reportMonth($payment_method, $limit, $month){
        return $this->reportRI->reportMonth($payment_method, $limit, $this->year, $month);
    }

    //Year
    public function reportYear($payment_method, $limit, $year){
        return $this->reportRI->reportYear($payment_method, $limit, $year);
    }

    public function getByDuration($duration, $payment_method, $limit){  
        switch ($duration) {
            case 'today':
                $sales = $this->reportDay($payment_method, $limit, $this->today);
                break;
            case 'yesterday':
                $sales = $this->reportDay($payment_method, $limit, $this->yesterday);
                break;
            case 'week':
                $sales = $this->reportWeek($payment_method, $limit, $this->nowWeekStart, $this->nowWeekEnd);
                break;
            case 'lastWeek':    
                $sales = $this->reportWeek($payment_method, $limit, $this->lastWeekStart, $this->lastWeekEnd);
                break;
            case 'month':
                $sales = $this->reportMonth($payment_method, $limit, $this->month);
                break;
            case 'lastMonth':
                $sales = $this->reportMonth($payment_method, $limit, $this->lastMonth);
                break;
            case 'year':
                $sales = $this->reportYear($payment_method, $limit, $this->year);
                break;
            case 'lastYear':
                $sales = $this->reportYear($payment_method, $limit, $this->lastYear);
                break;
            default:
            $sales = $this->reportDay($payment_method, $limit, $this->today);
        }
        return $sales;
    }

    public function PNL($duration, $payment_method){
        //
    }
    
    public function report($request)
    {
        if($request->has('payment_method')){
            $payment_method = $request->payment_method;
        }else{
            $payment_method = 'fiat';
        }

        if($request->has('limit')){
            $limit = $request->limit;
        }else{
            $limit = 5;
        }

        if($request->has('duration')){
            $duration = $request->duration;
            $sales = $this->getByDuration($duration, $payment_method, $limit);
        }else{
            $sales = $this->reportDay($payment_method, $limit, $this->today);
        }
        
        $total = 0;
        $tax = 0;
        $discount = 0;
        if(count($sales)>0){
            foreach($sales as $sale){
                $total = $total + $sale->total;
                $tax = $tax + $sale->tax;
                $discount = $discount + $sale->discount;
            }
            return [
                'payment_method' => $sales[0]->payment_method,
                'duration' => $duration,
                'total' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'sales'=> $sales
            ];
        }else{
            return response(["message"=>'Record Not Found'],404);
        }
    }
} 