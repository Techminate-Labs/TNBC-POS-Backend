<?php

namespace App\Services\Pos;

use Carbon\Carbon;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

//Service
use App\Services\Pos\PaymentMethodServices;

//Models
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
//Format
use App\Format\CartItemFormat;

class CartItemServices{
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;
    private $paymentMethodServices;

    public $cartModel = Cart::class;
    public $cartItemModel = CartItem::class;
    private $itemModel = Item::class;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface,
        PaymentMethodServices $paymentMethodServices,
        CartItemFormat $cartItemFormat
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->paymentMethodServices = $paymentMethodServices;
        $this->itemFormat = $cartItemFormat;
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
        $list = $this->paymentMethodServices->paymentMethod($request, $cartItems);
        return [
            'cashier' => $cart->user->name,
            'payment_method' => $list['payment_method'],
            'invoice_number' => 'POS_'.date('md').'_'.date('is').mt_rand(10,100),
            'subTotal' => (round($list['subTotal'], 4)),
            'discount' => (round($list['discount'], 4)),
            'tax' => (round($list['tax'], 4)),
            'total' => (round($list['total'], 4)),
            'date' => Carbon::now(),
            'cart_id' => $cart->id,
            'user_id' => $cart->user_id,
            'customer_id' => $cart->customer_id,
            'cartItems' => $list['cartItems']
        ];
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

            //check if Item exist
            $itemExits = $this->filterRI->filterBy2PropFirst($this->cartItemModel, $cart->id, $item->id, 'cart_id', 'item_id');
            if(count((array)$itemExits)>0){
                $itemExits->qty = $itemExits->qty + 1;
                $itemExits->total_amount = $itemExits->qty * $itemExits->unit_price;
                $itemExits->save();
            }else{
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
            }

            $item->inventory = $item->inventory - 1;
            $item->save();
            if($item->inventory <= 0){
                $item->available = 0;
                $item->save();
            }  
            return response(["done"=>'Item Added Successfully'],201);
        }else{
            return response(["failed"=>'Not Available To Purchase.'],201);
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

    public function updateStock($model, $itemId, $qty)
    {
        $item = $this->baseRI->findById($model, $itemId);
        $stock = $item->inventory;
        $stock = $stock + $qty;
        $item->inventory = $stock;
        $item->available = $this->updateAvailability($stock);
        $item->save();
    }

    public function updateAvailability($stock)
    {
        if($stock <= 0){
            return 0;
        }else{
            return 1;
        }
    }
}