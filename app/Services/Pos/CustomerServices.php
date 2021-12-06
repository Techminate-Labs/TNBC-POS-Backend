<?php

namespace App\Services\Pos;

use Illuminate\Support\Str;

//Services
use App\Services\BaseServices;

//Models
use App\Models\Customer;

class CustomerServices extends BaseServices{

    private $customerModel = Customer::class;

    public function customerList($request){
        if ($request->has('q')){
            $customer = $this->filterRI->filterBy4PropPaginated(
                $this->customerModel, $request->q, $request->limit,
                'name', 'email', 'phone', 'address'
            );
        }else{
            $customer = $this->baseRI->listWithPagination($this->customerModel, $request->limit);
        }
        return $customer;
    }

    public function customerGetById($id){
        $customer = $this->baseRI->findById($this->customerModel, $id);
        if($customer){
            return $customer;
        }else{
            return response(["failed"=>'customer not found'],404);
        }
    }

    public function customerCreate($request){
        $fields = $request->validate([
            'name'=>'required|string|unique:categories,name',
            'phone'=>'required|numeric'
        ]);
        $customer = $this->baseRI->storeInDB(
            $this->customerModel,
            [
                'name' => $fields['name'],
                'phone' => $fields['phone'],
                'email' => $request->email,
                'address' => $request->address,
                'point' => 0,
            ]
        );

        if($customer){
            return response($customer,201);
        }else{
            return response(["failed"=>'Server Error'],404);
        }
    }

    public function customerUpdate($request, $id){
        $customer = $this->baseRI->findById($this->customerModel, $id);
        if($customer){
            $data = $request->all();
            $fields = $request->validate([
                'name'=>'required|string',
                'phone'=>'numeric',
            ]);
            $customer->update([
                'name' => $fields['name'],
                'phone' => $fields['phone'],
                'email' => $request->email,
                'address' => $request->address,
                'point' => $customer->point,
            ]);
            return response($customer,201);
        }else{
            return response(["failed"=>'customer not found'],404);
        }
    }

    public function customerDelete($id){
        $customer = $this->baseRI->findById($this->customerModel, $id);
        if($customer){
            $customer->delete();
            return response(["done"=>'customer Deleted Successfully'],200);
        }else{
            return response(["failed"=>'customer not found'],404);
        }
    }
}