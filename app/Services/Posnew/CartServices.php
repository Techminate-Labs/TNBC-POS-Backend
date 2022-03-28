<?php

namespace App\Services\Pos;

//Interface
use App\Contracts\FilterRepositoryInterface;

//Models
use App\Models\Cart;

class CartServices{
    private $filterRepositoryInterface;
    private $cartRepositoryInterface;
    
    public function __construct(
        FilterRepositoryInterface $filterRepositoryInterface
    ){
        $this->filterRI = $filterRepositoryInterface;
        $this->cartModel = Cart::class;
    }

    public function cartAddCustomer($request)
    {
        $user_id = auth()->user()->id;
        $cart = $this->filterRI->filterBy1PropFirst($this->cartModel, $user_id, 'user_id');
        $cart->customer_id = $request->customer_id;
        $success=$cart->save();
        if($success){
            return response(["done"=>'Customer Added Successfully'],200);
        }else{
            return response(["error"=>'Server Error'],500);
        }
    }
}