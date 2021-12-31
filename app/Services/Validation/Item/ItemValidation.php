<?php

namespace App\Services\Validation\Item;

class ItemValidation{
    public static function validate1($request){
        return $request->validate([
            'category_id'=>'required|numeric',
            'brand_id'=>'required|numeric',
            'unit_id'=>'required|numeric',
            'supplier_id'=>'required|numeric',
            'name'=>'required|string|unique:categories,name',
            'price'=>'required|numeric',
            'inventory'=>'required|numeric',
        ]);
    }
}