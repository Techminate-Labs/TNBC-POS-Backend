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

class CartItemController extends Controller
{
    public function cartItemList()
    {
        $cartItems = CartItem::with('item')->latest()->get();
        return $cartItems;
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
            $cart_id = $cart->id;
            $unit_id = $item->unit_id;
            $unit_price = $item->price;
            $qty=1;
            $total_amount = $unit_price;

            $success = CartItem::create([
                'cart_id' => $cart_id,
                'item_id' => $item_id,
                'unit_id' => $unit_id,
                'unit_price' => $unit_price,
                'qty'=>$qty,
                'total_amount' => $total_amount
            ]);

            $item->inventory = $item->inventory-1;
            $item->save();
            if($item->inventory <= 0){
                $item->available = 0;
                $item->save();
            }  
            if($success){
                return response(["done"=>'Item Added Successfully'],201);
            }
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
            return response()->json($this->index());
        }
    }

    public function cartItemDelete($id)
    {
        $cartItem =  CartItem::find($id);
        $cartItem->delete();
        //check item qty and add it in stock after delete
        return response()->json($this->index());
    }
}
