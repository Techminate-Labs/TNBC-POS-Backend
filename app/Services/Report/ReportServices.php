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
    
    // date, payment_method, invoice_id, num_of_items, sold_by, customer, subTotal, discount, tax, total, profit
    
    //Today
    public function reportToday($payment_method){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at','=', date("m"))
                        ->whereDate('created_at', '=', Carbon::today())
                        ->get();
    }

    //Yesterday
    public function reportYesterday($payment_method){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at','=', date("m"))
                        ->whereDate('created_at', '=', Carbon::today()->subDay())
                        ->get();
    }

    //This Week
    public function reportWeek($payment_method){
        return Invoice::where('payment_method', $payment_method)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SATURDAY),Carbon::now()->endOfWeek(Carbon::FRIDAY)])
                    ->get();
    }

    //Last Week
    public function reportLastWeek($payment_method){
        // $startOfTheWeek = Carbon::now()->subWeek(1)->startOfWeek();
        // $endOfTheWeek = Carbon::now()->subWeek(1)->endOfWeek();
        
        // return Invoice::whereBetween('created_at',[$startOfTheWeek, $endOfTheWeek])
        //             ->get();

        $previous_week = strtotime("-1 week +1 day");

        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);
        
        $start_week = date("Y-m-d",$start_week);
        $end_week = date("Y-m-d",$end_week);


        return Invoice::whereBetween('created_at',[$start_week, $end_week])
                    ->get();
    }

    //This Month
    public function reportMonth($payment_method){
        return Invoice::where('payment_method', $payment_method)
        ->whereYear('created_at', date('Y'))
        ->whereMonth('created_at','=', date("m"))
        ->get();
    }

    //This Year
    public function reportYear($payment_method){
        return Invoice::where('payment_method', $payment_method)
        ->whereYear('created_at', date('Y'))
        ->get();
    }
    
    public function report($request)
    {
        if($request->has('payment_method')){
            $payment_method = $request->payment_method;
        }else{
            $payment_method = 'fiat';
        }

        if($request->has('duration')){
            $duration = $request->duration;
            switch ($duration) {
                case 'today':
                    $sales = $this->reportToday($payment_method);
                    break;
                case 'yesterday':
                    $sales = $this->reportYesterday($payment_method);
                    break;
                case 'week':
                    $sales = $this->reportWeek($payment_method);
                    break;
                case 'lastWeek':
                    $sales = $this->reportLastWeek($payment_method);
                    break;
                case 'month':
                    $sales = $this->reportMonth($payment_method);
                    break;
                case 'year':
                    $sales = $this->reportMonth($payment_method);
                    break;
                default:
                $sales = $this->reportToday($payment_method);
            }
        }else{
            $sales = $this->reportToday($payment_method);
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