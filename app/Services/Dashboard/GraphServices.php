<?php

namespace App\Services\Dashboard;

//Service
use App\Services\BaseServices;

//Models
use App\Models\Invoice;

class GraphServices extends BaseServices{

    private $brandModel = Invoice::class;

    public function countTotal()
    {
        return 'ok';
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