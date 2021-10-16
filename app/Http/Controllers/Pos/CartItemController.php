<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Pos\CartServices;

//Models
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;

//Format
use App\Format\CartItemFormat;

class CartItemController extends Controller
{
    public function __construct(CartItemFormat $cartItemFormat){
        $this->itemFormat = $cartItemFormat;
    }

    public function cartItemList()
    {
        $cartItems = CartItem::latest()
                    ->paginate(10)
                    ->through(function($cartItem){
                        return $this->itemFormat->formatCartItemList($cartItem);
                    });

        $subtotal = $this->payment($cartItems);

        $response = [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'discount' => 0,
            'tax' => 0,
            'total' => 0,
        ];
        return response($response, 200);
    }

    public function payment($cartItems)
    {
        $payment = 0;
        foreach($cartItems as $cartItem){
            $totalAmount = $cartItem->price * $cartItem->qty;
            $payment = $payment + $totalAmount;
        }

        return $payment;
    }

    //adding Item to cart
    public function cartItemCreate(Request $request)
    {
        $item_id = $request->item_id;
        $item = Item::where('id', $item_id)->first();

        $inStock = $item->inventory > 0;
        $availableToPurchase = $item->available;

        if($inStock && $availableToPurchase){
            $cart = Cart::where('user_id', auth()->user()->id)->first();
           
            CartItem::create([
                'cart_id' => $cart->id,
                'item_id' => $item->id,
                'unit_id' => $item->unit_id,
                'unit_price' => $item->price,
                'qty'=> 1,
                'total_amount' => $item->price
            ]);

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

    //Updating CartItem Quantity
    public function cartItemUpdate(Request $request, $id)
    {
        $cartItem =  CartItem::find($id);

        $cartItem->qty = $request->qty;
        $success=$cartItem->save();
        if($success){
            return response(["done"=>'Quantity Updated Successfully'],201);
        }
    }

    public function cartItemDelete($id)
    {
        $cartItem = CartItem::find($id);
        $qty = $cartItem->qty;
        $itemId = $cartItem->item_id;
        $cartItem->delete();
        //check item qty and add it in stock after delete
        $item = Item::where('id', $itemId)->first();
        $stock = $item->inventory;
        $item->inventory = $stock + $qty;
        $item->save();
        if($item->inventory == 1){
            $item->available = 1;
            $item->save();
        }
        return response(["done"=>'Item Deleted Successfully'],201);
    }
}
