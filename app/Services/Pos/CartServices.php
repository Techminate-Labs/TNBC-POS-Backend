<?php

namespace App\Services\Pos;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Models
use App\Models\Cart;
use App\Models\CartItem;

class CartServices{
    
    private $repositoryInterface;
    
    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Cart::class;
    }

    public function cartAddCustomer($request)
    {
        $cart = Cart::where('user_id',auth()->user()->id)->first();
        if(!$cart){
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->save();
        }
        
        $cart->customer_id = $request->customer_id;
        $success=$cart->save();
        if($success){
            return response(["done"=>'Customer Added Successfully'],200);
        }
    }
}