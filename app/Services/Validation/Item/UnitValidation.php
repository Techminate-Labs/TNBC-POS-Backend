<?php

namespace App\Services\Validation\Item;

class UnitValidation{
    public static function validate1($request){
        return $request->validate([
            'name'=>'required|string|max:255|unique:units,name',
        ]);
    }

    public static function validate2($request){
        return $request->validate([
            'name'=>'required|string|max:255',
        ]);
    }
}