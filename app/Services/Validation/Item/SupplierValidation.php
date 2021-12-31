<?php

namespace App\Services\Validation\Item;

class SupplierValidation{
    public static function validate1($request){
        return $request->validate([
            'name'=>'required|string',
            'email'=>'email',
            'phone'=>'numeric',
            'company'=>'string',
        ]);
    }
}