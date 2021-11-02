<?php

namespace App\Services\Pos;

//Interface
use App\Contracts\BaseRepositoryInterface;

//Service
use App\Services\Pos\PaymentServices;

//Models
use App\Models\Configuration;

class PaymentMethodServices{
    private $paymentServices;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        PaymentServices $paymentServices
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->paymentServices = $paymentServices;

        $this->configModel = Configuration::class;
    }

    public function payWithFIAT($request, $cartItems)
    {
        $payment = $this->paymentServices->calPayment($request, $cartItems);

        return [
            'cartItems' => $cartItems,
            'subTotal' => $payment['subTotal'],
            'discount' => $payment['discount'],
            'tax' => $payment['tax'],
            'total' => $payment['total'],
        ];
    }

    public function payWithTNBC($request, $cartItems)
    {
        $configuration = $this->baseRI->findById($this->configModel, 1);
        $tnbcRate = $configuration->tnbc_rate;

        $payment = $this->paymentServices->calPayment($request, $cartItems);

        $subTotalTNBC = $payment['subTotal']/$tnbcRate;
        $discountTNBC = $payment['discount']/$tnbcRate;
        $taxTNBC = $payment['tax']/$tnbcRate;
        $totalTNBC = $payment['total']/$tnbcRate;

        $tnbc=[];

        foreach($cartItems as $cartItem){
            $unit_price = $cartItem['unit_price'] /$tnbcRate;
            $total = $cartItem['total'] /$tnbcRate;
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
}