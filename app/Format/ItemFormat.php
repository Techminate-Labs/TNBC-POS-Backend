<?php

namespace App\Format;

class ItemFormat{
    public function isAvailable($data){
        if($data == 1){
            return true;
        }else{
            return false;
        }
    }

    public function formatItemList($item){
        return[
            'item_id' => $item->id,
            'category_id' => $item->category_id,
            'brand_id' => $item->brand_id,
            'unit_id' => $item->unit_id,
            'supplier_id' => $item->supplier_id,
            'category' => $item->category->name,
            'brand' => $item->brand->name,
            'unit' => $item->unit->name,
            'supplier' => $item->supplier->name,
            'company' => $item->supplier->company,
            'name' => $item->name,
            'slug' => $item->slug,
            'sku' => $item->sku,
            'price' => $item->price,
            'discount' => $item->discount,
            'inventory' => $item->inventory,
            'expire_date' => $item->expire_date,
            'available' => $this->isAvailable($item->available),
            'image' => $item->image,
            'created_at'=>$item->created_at->diffForHumans(),
            'updated_at'=>$item->updated_at->diffForHumans()
        ];
    }
}