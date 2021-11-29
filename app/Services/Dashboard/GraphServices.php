<?php

namespace App\Services\Dashboard;

//Interface
use App\Contracts\DashboardRepositoryInterface;

class GraphServices{
    private $dashboardRepositoryInterface;

    public function __construct(
        DashboardRepositoryInterface $dashboardRepositoryInterface
    ){
        $this->dashboardRI = $dashboardRepositoryInterface;
    }

    public function dateViewChart($request)
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $payment_method = $request->payment_method;

        $sales = $this->dashboardRI->dateViewChart($invoiceTable, $prop, $payment_method);

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->months;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function dayViewChart($request)
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $payment_method = $request->payment_method;

        $sales = $this->dashboardRI->dayViewChart($invoiceTable, $prop, $payment_method);

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->day_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function monthViewChart($request)
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $payment_method = $request->payment_method;

        $sales = $this->dashboardRI-> monthViewChart($invoiceTable, $prop, $payment_method);

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->month_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }
}