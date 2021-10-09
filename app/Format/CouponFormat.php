<?php

namespace App\Format;

class CouponFormat{
    public function isActive($data){
        if($data == 1){
            return true;
        }else{
            return false;
        }
    }

    public function formatCouponList($coupon){
        return[
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $coupon->discount,
            'start_date' => $coupon->start_date,
            'end_date' => $coupon->end_date,
            'active' => $this->isActive($coupon->active),
            'created_at'=>$coupon->created_at->diffForHumans(),
            'updated_at'=>$coupon->updated_at->diffForHumans()
        ];
    }
}