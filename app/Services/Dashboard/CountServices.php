<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Str;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

//Models
use App\Models\Invoice;

class CountServices{
    
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->brandModel = Invoice::class;
    }

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