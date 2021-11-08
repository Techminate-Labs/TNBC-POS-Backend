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
    
    // daily, weekly, monthly, yearly
    // date, payment_method, invoice_id, num_of_items, sold_by, customer, subTotal, discount, tax, total, profit
    public function report($request)
    {
        if($request->has('payment_method')){
            $payment_method = $request->payment_method;
        }else{
            $payment_method = 'fiat';
        }
        if($request->has('duration')){
            $duration = $request->duration;
        }else{
            $duration = Carbon::today();
        }
        $sales = Invoice::where('payment_method', $payment_method)->get();
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

    public function reportTNBC($request)
    {
        $sales = Invoice::where('payment_method', 'fiat')->get();
        $total = 0;
        $tax = 0;
        $discount = 0;
        foreach($sales as $sale){
            $total = $total + $sale->total;
            $tax = $tax + $sale->tax;
            $discount = $discount + $sale->discount;
        }
        return [
            'payment_method' => 'fiat',
            'total' => $total,
            'discount' => $discount,
            'tax' => $tax,
            'sales'=> $sales
        ];
    }
} 