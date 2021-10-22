<?php

namespace App\Services\Pos;

use Carbon\Carbon;

//Interface
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
    
    private $cartRepositoryInterface;
    
    public function __construct(
        CartRepositoryInterface $cartRepositoryInterface,

        CartItemFormat $cartItemFormat
    ){
        $this->cartRI = $cartRepositoryInterface;
        
        $this->itemModel = Item::class;
        $this->cartModel = Cart::class;
        $this->cartItemModel = CartItem::class;

        $this->itemFormat = $cartItemFormat;
    }

    //Update Quantity of CartItem
    public function cartItemUpdate($request, $id)
    {
        $cartItem = $this->cartRI->findById($this->cartItemModel, $id);
        if($cartItem){
            $itemId = $cartItem->item_id;
            $item = $this->cartRI->findById($this->itemModel, $itemId);
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
        $cartItem = $this->cartRI->findById($this->cartItemModel, $id);
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
        //check item qty and add it in stock after delete
        $item = $this->cartRI->findById($model, $itemId);
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