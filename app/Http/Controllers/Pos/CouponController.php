<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Item\CouponServices;

class CouponController extends Controller
{
    private $couponServices;

    public function __construct(CouponServices $couponServices){
        $this->services = $couponServices;
    }

    public function couponList(Request $request)
    {
        return $this->services->couponList($request);
    }

    public function couponGetById($id)
    {
        return $this->services->couponGetById($id);
    }

    public function couponCreate(Request $request)
    {
        return $this->services->couponCreate($request);
    }

    public function couponUpdate(Request $request, $id)
    {
        return $this->services->couponUpdate($request, $id);
    }

    public function couponDelete($id)
    {
        return $this->services->couponDelete($id);
    }
}