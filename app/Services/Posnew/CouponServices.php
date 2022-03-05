<?php

namespace App\Services\Pos;

//Services
use App\Services\BaseServices;
use App\Services\Validation\Pos\CouponValidation;

//Models
use App\Models\Coupon;

class CouponServices extends BaseServices{
    
    private $couponModel = Coupon::class;

    public function couponList($request){
        if ($request->has('q')){
            $coupon = $this->filterRI->filterBy1PropPaginated($this->couponModel, $request->q, $request->limit, 'code');
        }else{
            $coupon = $this->baseRI->listWithPagination($this->couponModel, $request->limit);
        }
        return $coupon;
    }

    public function couponGetById($id){
        $coupon = $this->baseRI->findById($this->couponModel, $id);
        if($coupon){
            return $coupon;
        }else{
            return response(["message"=>'coupon not found'],404);
        }
    }

    public function couponCreate($request){
        $fields = CouponValidation::validate1($request);
        $coupon = $this->baseRI->storeInDB(
            $this->couponModel,
            [
                'code' => rand(1111,100000),
                'discount' => $fields['discount'],
                'start_date' => $fields['start_date'],
                'end_date' => $fields['end_date'],
                'active' => $fields['active'],
            ]
        );

        if($coupon){
            return response($coupon,201);
        }else{
            return response(["message"=>'server error'],500);
        }
    }

    public function couponUpdate($request, $id){
        $coupon = $this->baseRI->findById($this->couponModel, $id);
        if($coupon){
            $fields = CouponValidation::validate1($request);
            $coupon->update([
                'discount' => $fields['discount'],
                'start_date' => $fields['start_date'],
                'end_date' => $fields['end_date'],
                'active' => $fields['active']
            ]);
            return response($coupon,201);
        }else{
            return response(["message"=>'coupon not found'],404);
        }
    }

    public function couponDelete($id){
        $coupon = $this->baseRI->findById($this->couponModel, $id);
        if($coupon){
            $coupon->delete();
            return response(["message"=>'coupon deleted successfully'],200);
        }else{
            return response(["message"=>'coupon not found'],404);
        }
    }
}