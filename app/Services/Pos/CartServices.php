<?php

namespace App\Services\Pos;

//Interface
use App\Contracts\Pos\CartRepositoryInterface;

//Models
use App\Models\Cart;

class CartServices{
    
    private $repositoryInterface;
    
    public function __construct(CartRepositoryInterface $cartRepositoryInterface){
        $this->cartRI = $cartRepositoryInterface;
        $this->cartModel = Cart::class;
    }

    public function cartAddCustomer($request)
    {
        $user_id = auth()->user()->id;
        $cart = $this->cartRI->getCart($this->cartModel, $user_id);
        $cart->customer_id = $request->customer_id;
        $success=$cart->save();
        if($success){
            return response(["done"=>'Customer Added Successfully'],200);
        }else{
            return response(["error"=>'Server Error'],500);
        }
    }
}