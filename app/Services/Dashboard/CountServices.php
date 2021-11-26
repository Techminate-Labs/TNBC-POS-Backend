<?php

namespace App\Services\Dashboard;

//Service
use App\Services\BaseServices;

//Models
use App\Models\Invoice;
use App\Models\Item;

class CountServices extends BaseServices{

    private $brandModel = Invoice::class;

    public function countTotal()
    {
        $invoiceTnbc = Invoice::where('payment_method','tnbc')->get();
        $invoiceFiat = Invoice::where('payment_method','fiat')->get();
        $items = Item::all();
        
        $salesTnbc = count($invoiceTnbc);
        $salesFiat = count($invoiceFiat);
        $totalItems = count($items);
        return [
            'salesTnbc'=> $salesTnbc,
            'salesFiat'=> $salesFiat,
            'totalItems'=> $totalItems
        ];
    }

    public function monthlySalesChart()
    {
        return 'ok';
    }

    public function dayChart()
    {
        return 'ok';
    }

}