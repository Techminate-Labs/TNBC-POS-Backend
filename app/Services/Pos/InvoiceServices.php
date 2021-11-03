<?php

namespace App\Services\Pos;

//Service
use App\Services\Pos\CartItemServices;

//Models
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceServices extends CartItemServices{
    private $invoiceModel = Invoice::class;
    private $invoiceItemModel = InvoiceItem::class;
       
    public function invoice($request)
    {
        $list = $this->cartItemList($request);
        $invoice = $this->baseRI->storeInDB(
            $this->invoiceModel,
            [
                'user_id' => $list['user_id'],
                'customer_id' => $list['customer_id'],
                'invoice_number' => 'INV'.date('mdis').mt_rand(10,100),
                'payment_method' => $list['payment_method'],
                'subTotal' => $list['subTotal'],
                'discount' => $list['discount'],
                'tax' => $list['tax'],
                'total' => $list['total'],
                'date' => $list['date'],
            ]
        );

        // foreach($list['cartItems'] as $item){
        //     $invoiceItem = $this->baseRI->storeInDB(
        //         $this->invoiceItemModel,
        //         [
        //             //
        //         ]
        // }

        return [
            'cashier' => $invoice->user->name,
            'invoice_number' => $invoice->invoice_number,
            'payment_method' => $invoice->payment_method,
            'subTotal' => $invoice->subTotal,
            'discount' => $invoice->discount,
            'tax' => $invoice->tax,
            'total' => $invoice->total,
            'date' => $invoice->date,
            'invoiceItems' => $list['cartItems']
        ];
    }
}