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
                        ->whereYear('date', date('Y'))
                        ->whereMonth('date','=', date("m"))
                        ->whereDate('date', '=', Carbon::today())
                        ->get();
    }

    //Yesterday
    public function reportYesterday($payment_method){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', date('Y'))
                        ->whereMonth('date','=', date("m"))
                        ->whereDate('date', '=', Carbon::today()->subDay())
                        ->get();
    }

    //This Week
    public function reportWeek($payment_method){
        // $startOfTheWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        // $endOfTheWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);

        $startOfTheWeek = Carbon::now()->startOfWeek();
        $endOfTheWeek = Carbon::now()->endOfWeek();

        return Invoice::where('payment_method', $payment_method)
                        ->whereBetween('date', [$startOfTheWeek, $endOfTheWeek])
                        ->get();
    }

    //Last Week
    public function reportLastWeek($payment_method){
        $startOfTheWeek = Carbon::now()->subWeek(1)->startOfWeek();
        $endOfTheWeek = Carbon::now()->subWeek(1)->endOfWeek();
        
        return Invoice::where('payment_method', $payment_method)
                        ->whereBetween('date', [$startOfTheWeek, $endOfTheWeek])
                        ->get();
    }

    //This Month
    public function reportMonth($payment_method){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', date('Y'))
                        ->whereMonth('date','=', date("m"))
                        ->get();
    }

     //Last Month
     public function reportLastMonth($payment_method){
        $startDay = Carbon::now()->subWeek(1)->startOfWeek();
        $endDay = Carbon::now()->subWeek(1)->endOfWeek();

        return Invoice::where('payment_method', $payment_method)
                        ->whereBetween('date', [$startDay, $endDay])
                        ->get();
    }

    //This Year
    public function reportYear($payment_method){
        return Invoice::where('payment_method', $payment_method)
                        ->whereYear('date', date('Y'))
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
                case 'lastMonth':
                    $sales = $this->reportMonth($payment_method);
                    break;
                case 'year':
                    $sales = $this->reportYear($payment_method);
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