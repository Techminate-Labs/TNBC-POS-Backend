<?php

namespace App\Services\Pos;
use Illuminate\Support\Facades\DB;

//Service
use App\Services\Pos\CartItemServices;

//Models
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;

class InvoiceServices extends CartItemServices{
    private $invoiceModel = Invoice::class;
    private $invoiceItemModel = InvoiceItem::class;
    private $customerModel = Customer::class;
       
    public function invoiceCreate($request)
    {
        if($request->has('invoice_number')){
            $invoice_number = $request->invoice_number;
        }else{
            $invoice_number = 'INV'.date('mdis').mt_rand(10,100);
        }
        $list = $this->cartItemList($request);
        $invoice = $this->baseRI->storeInDB(
            $this->invoiceModel,
            [
                'user_id' => $list['user_id'],
                'customer_id' => $list['customer_id'],
                'invoice_number' => $invoice_number,
                'payment_method' => $list['payment_method'],
                'subTotal' => $list['subTotal'],
                'discount' => $list['discount'],
                'tax' => $list['tax'],
                'total' => $list['total'],
                'date' => $list['date'],
            ]
        );

        foreach($list['cartItems'] as $item){
            $invoiceItem = $this->baseRI->storeInDB(
                $this->invoiceItemModel,
                [
                    'invoice_id' => $invoice->id,
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'unit' => $item['unit'],
                    'unit_price' => $item['unit_price'],
                    'qty' => $item['qty'],
                    'total' => $item['total']
                ]
            );
            $cartItem = $this->baseRI->findById($this->cartItemModel, $item['id']);
            $cartItem->delete();
        }

        $cart = $this->baseRI->findById($this->cartModel, $list['cart_id'],);
        if($cart){
            $cart->customer_id = NULL;
            $cart->save();
        }

        return response(["done"=>'Invoice Saved Successfully'],201);

        // return [
        //     'cashier' => $invoice->user->name,
        //     'payment_method' => $invoice->payment_method,
        //     'invoice_number' => $invoice->invoice_number,
        //     'subTotal' => $invoice->subTotal,
        //     'discount' => $invoice->discount,
        //     'tax' => $invoice->tax,
        //     'total' => $invoice->total,
        //     'date' => $invoice->date,
        //     'invoiceItems' => $list['cartItems']
        // ];
    }

    public function invoiceList($request)
    {
        return $this->baseRI->listWithPagination($this->invoiceModel, $request->limit);
    }

    public function invoiceGetById($id)
    {
        $invoice = $this->baseRI->findById($this->invoiceModel, $id);
        if($invoice){
            $invoiceItems = $this->baseRI->findByIdGet($this->invoiceItemModel, $invoice->id, 'invoice_id');
        }else{
            return response(["failed"=>'Invoice not found'],404);
        }

        return [
            'invoice' => $invoice,
            'invoiceItems' => $invoiceItems
        ];
    }
}