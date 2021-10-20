<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

//Interface
use App\Contracts\Pos\CartRepositoryInterface;

//Service
use App\Services\Pos\CartServices;
use App\Services\Pos\CartItemServices;

//Models
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Coupon;

//Format
use App\Format\CartItemFormat;

class CartItemController extends Controller
{
    public function __construct(
        CartRepositoryInterface $cartRepositoryInterface,
        CartItemFormat $cartItemFormat,
        CartItemServices $cartItemServices

    ){
        $this->cartRI = $cartRepositoryInterface;
        $this->cartModel = Cart::class;
        $this->itemFormat = $cartItemFormat;

        $this->services = $cartItemServices;
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

    public function calPayment($cartItems,  $discountRate, $taxRate){
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
        $coupon = Coupon::where('code', 'LIKE', '%' . $code . '%')->first();

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

    public function cartItemList(Request $request)
    {
        $user_id = auth()->user()->id;
        $cart = $this->cartRI->getCart($this->cartModel, $user_id);

        $cartItems = CartItem::where('cart_id', $cart->id)->get()
                       ->map(function($cartItem){
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

    //Update Quantity of CartItem
    public function cartItemUpdate(Request $request, $id)
    {
        return $this->services->cartItemUpdate($request, $id);
    }

    public function cartItemDelete($id)
    {
        return $this->services->cartItemDelete($id);
    }
}
