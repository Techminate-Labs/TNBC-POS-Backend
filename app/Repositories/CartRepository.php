<?php

namespace App\Repositories;

//Interface
use App\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface{

    public function createCart($model, $id){
        $cart = new $model();
        $cart->user_id = $id;
        $cart->save();
        return $cart;
    }
}