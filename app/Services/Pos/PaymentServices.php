<?php

namespace App\Services\Pos;

use Carbon\Carbon;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

//Models
use App\Models\Coupon;
use App\Models\Configuration;

class PaymentServices{
    private $baseRepositoryInterface;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;

        $this->configModel = Configuration::class;
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

    public function calPayment($request, $cartItems)
    {
        $configuration = $this->baseRI->findById($this->configModel, 1);
        $taxRate = $configuration->tax_rate;
        $subTotal = $this->subTotal($cartItems);

        if($request->has('coupon')){
            $coupon = $this->baseRI->findByIdfirst($this->couponModel, $request->coupon, 'code');
            if($coupon){
                $discountRate = $this->applyCoupon($coupon);
            }else{
                $discountRate = 0;
            }
        }else{
            $discountRate = 0;
        }

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

    public function applyCoupon($coupon)
    {
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
}