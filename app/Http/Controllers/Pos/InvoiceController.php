<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Pos\InvoiceServices;

class InvoiceController extends Controller
{
    private $invoiceServices;

    public function __construct(InvoiceServices $invoiceServices){
        $this->services = $invoiceServices;
    }

    public function invoice(Request $request)
    {
        return $this->services->invoice($request);
    }
}
