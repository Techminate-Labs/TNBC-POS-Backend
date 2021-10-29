<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Pos\CartItemServices;

class CartItemController extends Controller
{
    public function __construct(
        CartItemServices $cartItemServices
    ){
        $this->services = $cartItemServices;
    }

    public function cartItemList(Request $request)
    {
        return $this->services->cartItemList($request);
    }

    public function cartItemCreate(Request $request)
    {
        return $this->services->cartItemCreate($request);
    }

    public function cartItemUpdate(Request $request, $id)
    {
        return $this->services->cartItemUpdate($request, $id);
    }

    public function cartItemDelete($id)
    {
        return $this->services->cartItemDelete($id);
    }
}
