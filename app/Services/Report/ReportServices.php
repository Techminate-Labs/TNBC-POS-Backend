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
    
    public function reportDay($payment_method){
        return Invoice::where('payment_method', $payment_method)
                        ->whereMonth('created_at','=', date("m"))
                        ->whereDate('created_at', '=', Carbon::today())->get();
    }

    public function reportWeek($payment_method){
        return Invoice::where('payment_method', $payment_method)
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SATURDAY),Carbon::now()->endOfWeek(Carbon::FRIDAY)])
        ->get();
    }

    public function reportMonth($payment_method){
        return Invoice::where('payment_method', $payment_method)
        ->whereYear('created_at', date('Y'))
        ->whereMonth('created_at','=', date("m"))
        ->get();
    }

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
                    $sales = $this->reportDay($payment_method);
                    break;
                case 'week':
                    $sales = $this->reportWeek($payment_method);
                    break;
                case 'month':
                    $sales = $this->reportMonth($payment_method);
                    break;
                case 'year':
                    $sales = $this->reportMonth($payment_method);
                    break;
                default:
                $sales = $this->reportDay($payment_method);
            }
        }else{
            $sales = $this->reportDay($payment_method);
        }
        
        $total = 0;
        $tax = 0;
        $discount = 0;
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
    }
} 