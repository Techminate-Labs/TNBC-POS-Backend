<?php

namespace App\Services\Validation\Pos;

class CouponValidation{
    public static function validate1($request){
        return $request->validate([
            'discount'=>'required|numeric',
            'start_date'=>'required|string',
            'end_date'=>'required|string',
            'active'=>'required',
        ]);
    }
}