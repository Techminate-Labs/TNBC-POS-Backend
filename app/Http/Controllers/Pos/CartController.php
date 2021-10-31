<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Pos\CartServices;

class CartController extends Controller
{
    private $cartServices;

    public function __construct(CartServices $cartServices){
        $this->services = $cartServices;
    }

    public function cartAddCustomer(Request $request)
    {
        return $this->services->cartAddCustomer($request);
    }
}
