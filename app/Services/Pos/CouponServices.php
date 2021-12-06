<?php

namespace App\Services\Pos;

//Services
use App\Services\BaseServices;

//Models
use App\Models\Coupon;

class CouponServices extends BaseServices{
    
    private $couponModel = Coupon::class;

    public function couponList($request){
        if ($request->has('q')){
            $coupon = $this->filterRI->filterBy1PropPaginated($this->couponModel, $request->q, $request->limit, 'code');
        }else{
            $coupon = $this->baseRI->listWithPagination($this->couponModel, $request->limit);
        }
        return $coupon;
    }

    public function couponGetById($id){
        $coupon = $this->baseRI->findById($this->couponModel, $id);
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

        $coupon = $this->baseRI->storeInDB(
            $this->couponModel,
            [
                'code' => rand(1111,100000),
                'discount' => $fields['discount'],
                'start_date' => $fields['start_date'],
                'end_date' => $fields['end_date'],
                'active' => $fields['active'],
            ]
        );

        if($coupon){
            return response($coupon,201);
        }else{
            return response(["failed"=>'server error'],500);
        }
    }

    public function couponUpdate($request, $id){
        $coupon = $this->baseRI->findById($this->couponModel, $id);
        if($coupon){
            $data = $request->all();
            $fields = $request->validate([
                'discount'=>'required|numeric',
                'start_date'=>'required|string',
                'end_date'=>'required|string',
                'active'=>'required',
            ]);
            $data['discount'] = $fields['discount'];
            $data['start_date'] = $fields['start_date'];
            $data['end_date'] = $fields['end_date'];
            $data['active'] = $fields['active'];
            $coupon->update($data);
            return response($coupon,201);
        }else{
            return response(["failed"=>'coupon not found'],404);
        }
    }

    public function couponDelete($id){
        $coupon = $this->baseRI->findById($this->couponModel, $id);
        if($coupon){
            $coupon->delete();
            return response(["done"=>'coupon Deleted Successfully'],200);
        }else{
            return response(["failed"=>'coupon not found'],404);
        }
    }
}