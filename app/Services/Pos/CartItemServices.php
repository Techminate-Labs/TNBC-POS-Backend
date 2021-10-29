<?php

namespace App\Services\Pos;

use Carbon\Carbon;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;
use App\Contracts\Pos\CartRepositoryInterface;
use App\Contracts\Item\ItemRepositoryInterface;

//Service
use App\Services\Pos\CartServices;

//Models
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Coupon;

//Format
use App\Format\CartItemFormat;

class CartItemServices{
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;
    private $cartRepositoryInterface;
    
    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface,
        CartRepositoryInterface $cartRepositoryInterface,

        CartItemFormat $cartItemFormat
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->cartRI = $cartRepositoryInterface;
        
        $this->itemFormat = $cartItemFormat;

        $this->itemModel = Item::class;
        $this->cartModel = Cart::class;
        $this->cartItemModel = CartItem::class;
        $this->couponModel = Coupon::class;
    }
    
    public function subTotal($cartItems)
    {
        $subTotal = 0;
        foreach($cartItems as $cartItem){
            $subTotal = $subTotal + $cartItem['total'];
        }
        return $subTotal;
    }

    public function percToAmount($percentage, $subTotal)
    {
        return ($percentage/100) * $subTotal;
    }

    public function calPayment($cartItems,  $discountRate, $taxRate)
    {
        $subTotal = $this->subTotal($cartItems);
        $discount = $this->percToAmount($discountRate, $subTotal);
        $total = $subTotal - $discount;
        $tax = $this->percToAmount($taxRate, $subTotal);
        $total = $total + $tax;
        
        return [
            'subTotal' => $subTotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ];
    }

    public function applyCoupon($code){
        $coupon = $this->filterRI->filterBy1PropFirst($this->couponModel,  $code, 'code');

        $today = Carbon::today();
        $startDate = $coupon->start_date; // start: 14 oct, 
        $endDate = $coupon->end_date;     //end: 20 oct

        //valid dates: 14, 15, 16, 17, 18, 19, 20;    
        //active coupon based on start and end date
        //Active : 14 <= today; 20 >= today
        if($startDate <= $today && $endDate >= $today){
            $coupon->active = 1;
            $coupon->save();
        }
        //if date is expired, inactive coupon
        //Invalid: 20 < today ; 20<17=false, 20<21=true
        if($endDate < $today){
            $coupon->active = 0;
            $coupon->save();
        }

        if($coupon->active){
            $discountRate = $coupon->discount;
        }else{
            $discountRate = 0;
        }
        return $discountRate;
    }

    //Items of the Cart
    public function cartItemList($request)
    {
        $user_id = auth()->user()->id;
        $cart = $this->filterRI->filterBy1PropFirst($this->cartModel, $user_id, 'user_id');
        $cartItems = $this->filterRI->filterBy1Prop($this->cartItemModel, $cart->id, 'cart_id');
        $cartItems = $cartItems->map(function($cartItem){
                        return $this->itemFormat->formatCartItemList($cartItem);
                    });

        if($request->has('coupon')){
            $discountRate = $this->applyCoupon($request->coupon);
        }else{
            $discountRate = 0;
        }

        $taxRate = 25;

        $payment = $this->calPayment($cartItems, $discountRate, $taxRate);

        $response = [
            'cartItems' => $cartItems,
            'subTotal' => $payment['subTotal'],
            'discount' => $payment['discount'],
            'tax' => $payment['tax'],
            'total' => $payment['total'],
        ];
        return response($response, 200);
    }

    //add Item to cart
    public function cartItemCreate($request)
    {
        $item_id = $request->item_id;
        $item = $this->baseRI->findById($this->itemModel, $item_id);

        $inStock = $item->inventory > 0;
        $availableToPurchase = $item->available;

        if($inStock && $availableToPurchase){
            $user_id = auth()->user()->id;
            $cart = $this->filterRI->filterBy1PropFirst($this->cartModel, $user_id, 'user_id');

            $cartItem = $this->baseRI->storeInDB(
                $this->cartItemModel,
                [
                    'cart_id' => $cart->id,
                    'item_id' => $item->id,
                    'unit_id' => $item->unit_id,
                    'unit_price' => $item->price,
                    'qty'=> 1,
                    'total_amount' => $item->price
                ]
            );

            $item->inventory = $item->inventory - 1;
            $item->save();
            if($item->inventory <= 0){
                $item->available = 0;
                $item->save();
            }  
            return response(["done"=>'Item Added Successfully'],201);
        }else{
            return response(["failed"=>'Not Available To Purchase.'],200);
        }
    }

    //Update Quantity of CartItem
    public function cartItemUpdate($request, $id)
    {
        $cartItem = $this->baseRI->findById($this->cartItemModel, $id);
        if($cartItem){
            $itemId = $cartItem->item_id;
            $item = $this->baseRI->findById($this->itemModel, $itemId);
            $stock = $item->inventory;

            $newQty = $request->qty;
            $prevQty = $cartItem->qty;

            if($newQty > $prevQty){
                $qty = $newQty - $prevQty;
                if($qty <= $stock){
                    $stock = $stock - $qty;
                }else{
                    $response = [
                        'max_qty' => $stock + $prevQty,
                        'message'=>'Can not add more than max quantity'
                    ];
                    return response($response, 200);
                }
            }else{
                $qty = $prevQty - $newQty;
                $stock = $stock + $qty;
            }
            $item->inventory = $stock;
            $item->available = $this->updateAvailability($stock);
            $item->save();

            $cartItem->qty = $newQty;
            $cartItem->total_amount = $cartItem->unit_price * $newQty;
            $cartItem->save();
            return response(["done"=>'Quantity Updated Successfully'],201);
        }else{
            return response(["error"=>'Item Not Found'],404);
        }
    }

    public function cartItemDelete($id)
    {
        $cartItem = $this->baseRI->findById($this->cartItemModel, $id);
        if($cartItem){
            $qty = $cartItem->qty;
            $itemId = $cartItem->item_id;
            $cartItem->delete();
            $this->updateStock($this->itemModel, $itemId, $qty);
            return response(["done"=>'Item Deleted Successfully'],201);
        }else{
            return response(["error"=>'Item Not Found'],404);
        }
    }

    public function updateStock($model, $itemId, $qty){
        $item = $this->baseRI->findById($model, $itemId);
        $stock = $item->inventory;
        $stock = $stock + $qty;
        $item->inventory = $stock;
        $item->available = $this->updateAvailability($stock);
        $item->save();
    }

    public function updateAvailability($stock){
        if($stock <= 0){
            return 0;
        }else{
            return 1;
        }
    }
}