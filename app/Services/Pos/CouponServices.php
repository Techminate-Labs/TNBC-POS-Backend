<?php

namespace App\Services\Pos;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Models
use App\Models\Coupon;

class CouponServices{
    
    private $repositoryInterface;
    
    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Coupon::class;
    }

    public function couponList($request){
        if ($request->has('q')){
            $coupon = $this->ri->couponSearch($this->model, $request->q, $request->limit);
        }else{
            $coupon = $this->ri->list($this->model, $request->limit);
        }
        return $coupon;
    }

    public function couponGetById($id){
        $coupon = $this->ri->dataGetById($this->model, $id);
        if($coupon){
            return $coupon;
        }else{
            return response(["failed"=>'coupon not found'],404);
        }
    }

    public function couponCreate($request){
        $fields = $request->validate([
            'discount'=>'required|numeric',
            'start_date'=>'required|string',
            'end_date'=>'required|string',
            'active'=>'required',
        ]);

        $coupon = $this->ri->dataCreate(
            $this->model,
            [
                'code' => rand(1111,100000),
                'discount' => $fields['discount'],
                'start_date' => $fields['discount'],
                'end_date' => $fields['discount'],
                'active' => $fields['discount'],
            ]
        );

        return response($coupon,201);
    }

    public function couponUpdate($request, $id){
        $coupon = $this->ri->dataGetById($this->model, $id);
        if($coupon){
            $data = $request->all();
            if($coupon->name==$data['name']){
                $fields = $request->validate([
                    'name'=>'required|string|max:255',
                ]);
            }
            else{
                $fields = $request->validate([
                    'name'=>'required|string|max:255|unique:categories,name',
                ]);
            }
            $data['slug'] = Str::slug($fields['name']);
            $coupon->update($data);
            return response($coupon,201);
        }else{
            return response(["failed"=>'coupon not found'],404);
        }
    }

    public function couponDelete($id){
        $coupon = $this->ri->dataGetById($this->model, $id);
        if($coupon){
            $coupon->delete();
            return response(["done"=>'coupon Deleted Successfully'],200);
        }else{
            return response(["failed"=>'coupon not found'],404);
        }
    }
}