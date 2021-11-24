<?php

namespace App\Services\Report;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

//Models
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;

class ReportServices{
    private $invoiceModel = Invoice::class;
    private $invoiceItemModel = InvoiceItem::class;
    private $itemModel = Item::class;

    public function __construct(){
       //
    }
    
    // num_of_items, PNL
    
    //Today
    public function reportToday($payment_method, $limit){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->whereDate('date', Carbon::today())
                        ->paginate($limit);
    }

    //Yesterday
    public function reportYesterday($payment_method, $limit){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->whereDate('date', Carbon::today()->subDay())
                        ->paginate($limit);
    }

    //This Week
    public function reportWeek($payment_method, $limit){
        $startOfTheWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfTheWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        return Invoice::where('payment_method', $payment_method)
                        ->whereBetween('date', [$startOfTheWeek, $endOfTheWeek])
                        ->paginate($limit);
    }

    //Last Week
    public function reportLastWeek($payment_method, $limit){
        $startOfTheWeek = Carbon::now()->subWeek(1)->startOfWeek();
        $endOfTheWeek = Carbon::now()->subWeek(1)->endOfWeek();
        
        return Invoice::where('payment_method', $payment_method)
                        ->whereBetween('date', [$startOfTheWeek, $endOfTheWeek])
                        ->paginate($limit);
    }

    //This Month
    public function reportMonth($payment_method, $limit){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->paginate($limit);
    }

     //Last Month
     public function reportLastMonth($payment_method, $limit){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date','=', Carbon::now()->subMonth())
                        ->paginate($limit);
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
                $sales = $this->reportToday($payment_method, $limit);
                break;
            case 'yesterday':
                $sales = $this->reportYesterday($payment_method, $limit);
                break;
            case 'week':
                $sales = $this->reportWeek($payment_method, $limit);
                break;
            case 'lastWeek':
                $sales = $this->reportLastWeek($payment_method, $limit);
                break;
            case 'month':
                $sales = $this->reportMonth($payment_method, $limit);
                break;
            case 'lastMonth':
                $sales = $this->reportLastMonth($payment_method, $limit);
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