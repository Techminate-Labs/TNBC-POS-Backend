<?php

namespace App\Services\Validation\Pos;

class CustomerValidation{
    public static function validate1($request){
        return $request->validate([
            'name'=>'required|string|unique:categories,name',
            'phone'=>'required|numeric'
        ]);
    }

    public static function validate2($request){
        return $request->validate([
            'name'=>'required|string|max:255',
        ]);
    }
}