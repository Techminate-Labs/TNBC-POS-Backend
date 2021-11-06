<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Pos\TransactionServices;

class TransactionController extends Controller
{
    private $transactionServices;

    public function __construct(TransactionServices $transactionServices){
        $this->services = $transactionServices;
    }

    public function transactionHistory(){
        return $this->services->transactionHistory();
    }
}
