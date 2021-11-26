<?php

namespace App\Services\Dashboard;
// use Illuminate\Support\Facades\DB;

//Service
use App\Services\BaseServices;

class CountServices extends BaseServices{

    public function countTotal()
    {
        $invoiceTable = 'invoices';
        $itemTable = 'items';
        $categoryTable = 'categories';

        $prop = 'payment_method';
        $query1 = 'tnbc';
        $query2 = 'fiat';

        $salesTnbc = \DB::table($invoiceTable)->where($prop, $query1)->count();
        $salesFiat = \DB::table($invoiceTable)->where($prop, $query2)->count();
        $items = \DB::table($itemTable)->count();
        $categories = \DB::table($categoryTable)->count();
        
        return [
            'salesTnbc'=> $salesTnbc,
            'salesFiat'=> $salesFiat,
            'totalItems'=> $items,
            'totalCategories'=> $categories,
        ];
    }
}