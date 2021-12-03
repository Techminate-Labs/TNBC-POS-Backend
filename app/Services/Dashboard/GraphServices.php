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
        $sales = $this->dashboardRI->dateViewChart($request->payment_method);

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->months;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function dayViewChart($request)
    {
        $sales = $this->dashboardRI->dayViewChart($request->payment_method);

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->day_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }

    public function monthViewChart($request)
    {
        $sales = $this->dashboardRI-> monthViewChart($request->payment_method);

        $data = [];
        foreach($sales as $sale) {
            $data['label'][] = $sale->month_name;
            $data['total'][] = (int)$sale->total;
        }
        return  $data;
    }
}