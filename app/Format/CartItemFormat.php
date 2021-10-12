<?php

namespace App\Format;

class cartItemFormat{
    public function formatCartItemList($cartItem){
        return[
            'id' => $cartItem->id,
            'cart_id' => $cartItem->cart_id,
            'item_id' => $cartItem->item_id,
            'item_name' => $cartItem->item->name,
            'unit' => $cartItem->unit->name,
            'unit_price' => $cartItem->unit_price,
            'qty' => $cartItem->qty,
            'total' => $cartItem->total_amount
        ];
    }
}