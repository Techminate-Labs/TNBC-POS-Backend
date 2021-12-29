<?php

namespace App\Services\Validation\Item;

class BrandValidation{
    public static function validate1($request){
        return $request->validate([
            'name'=>'required|string|unique:brands,name',
        ]);
    }

    public static function validate2($request){
        return $request->validate([
            'name'=>'required|string|max:255',
        ]);
    }
}