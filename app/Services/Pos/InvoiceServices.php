<?php

namespace App\Services\Pos;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;
use App\Contracts\Pos\CartRepositoryInterface;
use App\Contracts\Item\ItemRepositoryInterface;

//Service
use App\Services\Pos\CartItemServices;

//Models
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;

class InvoiceServices{
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;
    private $cartRepositoryInterface;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface,
        CartRepositoryInterface $cartRepositoryInterface,

        CartItemServices $cartItemServices
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->cartRI = $cartRepositoryInterface;

        $this->cartItemServices = $cartItemServices;

        $this->itemModel = Item::class;
        $this->cartModel = Cart::class;
        $this->cartItemModel = CartItem::class;
    }

    public function invoice($request){
        if($request->has('payment_method')){
            $pm = $request->payment_method;
            switch ($pm) {
                case 'tnbc':
                    $invoice = $this->payWithTNBC($request);
                    break;
                case 'fiat':
                    $invoice = $this->cartItemServices->cartItemList($request);
                    break;
                default:
                $invoice = $this->cartItemServices->cartItemList($request);
            }
            return response($invoice,200);
        }else{
            return response(["failed"=>'Please Select Payment Method'],404);
        }
    }

    public function payWithTNBC($request){
        $rate = 0.02;
        $cart = $this->cartItemServices->payDefault($request);
        $subTotalTNBC = $cart['subTotal']/$rate;
        $discountTNBC = $cart['discount']/$rate;
        $taxTNBC = $cart['tax']/$rate;
        $totalTNBC = $cart['total']/$rate;

        $tnbc=[];

        foreach($cart['cartItems'] as $cartItem){
            $unit_price = $cartItem['unit_price'] /$rate;
            $total = $cartItem['total'] /$rate;
            $obj = [
                "id"=>$cartItem['id'],
                "cart_id"=>$cartItem['cart_id'],
                "item_id"=>$cartItem['item_id'],
                "item_name"=>$cartItem['item_name'],
                "unit"=>$cartItem['unit'],
                "unit_price"=>$unit_price,
                "qty"=>$cartItem['qty'],
                "total"=>$total
            ];
            array_push($tnbc, $obj);
        }
        return [
            'cartItems' => $tnbc,
            'subTotal' => $subTotalTNBC,
            'discount' => $discountTNBC,
            'tax' => $taxTNBC,
            'total' => $totalTNBC
        ];
        
    }

    public function payWithFIAT($request){
        $rate = 0.02;
        $cart = $this->cartItemServices->cartItemList($request);
        $subTotalTNBC = $cart['subTotal']/$rate;
        $discountTNBC = $cart['discount']/$rate;
        $taxTNBC = $cart['tax']/$rate;
        $totalTNBC = $cart['total']/$rate;

        $tnbc=[];

        foreach($cart['cartItems'] as $cartItem){
            $unit_price = $cartItem['unit_price'] /$rate;
            $total = $cartItem['total'] /$rate;
            $obj = [
                "id"=>$cartItem['id'],
                "cart_id"=>$cartItem['cart_id'],
                "item_id"=>$cartItem['item_id'],
                "item_name"=>$cartItem['item_name'],
                "unit"=>$cartItem['unit'],
                "unit_price"=>$unit_price,
                "qty"=>$cartItem['qty'],
                "total"=>$total
            ];
            array_push($tnbc, $obj);
        }
        $response = [
            'fiat' => $cart['cartItems'],
            'tnbc' => $tnbc,
            'subTotal' => $cart['subTotal'],
            'discount' => $cart['discount'],
            'tax' => $cart['tax'],
            'total' => $cart['total'],
            'subTotalTNBC' => $subTotalTNBC,
            'discountTNBC' => $discountTNBC,
            'taxTNBC' => $taxTNBC,
            'totalTNBC' => $totalTNBC
        ];
        return response($response, 200);
    }
}