<?php

namespace App\Services\Report;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

//Interface
use App\Contracts\ReportRepositoryInterface;

//Models
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;

class ReportServices{
    private $reportRepositoryInterface;
    private $invoiceModel = Invoice::class;

    public function __construct(
        ReportRepositoryInterface $reportRepositoryInterface
    ){
        $this->reportRI = $reportRepositoryInterface;
    }
    
    //Day
    public function reportDay($payment_method, $limit, $day){
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        return $this->reportRI->reportDay($payment_method, $limit, $year, $month, $day);
    }

    //Week
    public function reportWeek($payment_method, $limit, $startOfTheWeek, $endOfTheWeek){
        $year = Carbon::now()->year;
        return $this->reportRI->reportWeek($payment_method, $limit, $year, $startOfTheWeek, $endOfTheWeek);
    }

    //This Month
    public function reportMonth($payment_method, $limit, $month){
        $year = Carbon::now()->year;
        return $this->reportRI->reportMonth($payment_method, $limit, $year, $month);
    }

    //This Year
    public function reportYear($payment_method, $limit){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->paginate($limit);
    }

     //Last Year
     public function reportLastYear($payment_method, $limit){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', Carbon::now()->subYear())
                        ->paginate($limit);
    }

    public function getByDuration($duration, $payment_method, $limit){  
        switch ($duration) {
            case 'today':
                $day = Carbon::today();
                $sales = $this->reportDay($payment_method, $limit, $day);
                break;
            case 'yesterday':
                $day = Carbon::today()->subDay();
                $sales = $this->reportDay($payment_method, $limit, $day);
                break;
            case 'week':
                $startOfTheWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
                $endOfTheWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
                $sales = $this->reportWeek($payment_method, $limit, $startOfTheWeek, $endOfTheWeek);
                break;
            case 'lastWeek':
                $startOfTheWeek = Carbon::now()->subWeek(1)->startOfWeek();
                $endOfTheWeek = Carbon::now()->subWeek(1)->endOfWeek();        
                $sales = $this->reportWeek($payment_method, $limit, $startOfTheWeek, $endOfTheWeek);
                break;
            case 'month':
                $month = Carbon::now()->month;
                $sales = $this->reportMonth($payment_method, $limit, $month);
                break;
            case 'lastMonth':
                $year = Carbon::now()->subMonth();
                $sales = $this->reportMonth($payment_method, $limit, $month);
                break;
            case 'year':
                $sales = $this->reportYear($payment_method, $limit);
                break;
            case 'lastYear':
                $sales = $this->reportLastYear($payment_method, $limit);
                break;
            default:
            $sales = $this->reportToday($payment_method, $limit);
        }
        return $sales;
    }

    public function PNL($duration, $payment_method){  
        switch ($duration) {
            case 'today':
                $sales = $this->reportToday($payment_method);
                break;
            case 'week':
                $sales = $this->reportWeek($payment_method);
                break;
            case 'month':
                $sales = $this->reportMonth($payment_method);
                break;
            case 'year':
                $sales = $this->reportYear($payment_method);
                break;
            default:
            $sales = $this->reportToday($payment_method);
        }
        return $sales;
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
            $sales = $this->reportToday($payment_method, $limit);
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
            return response(["notFound"=>'Record Not Found'],404);
        }
    }
} 