<?php

namespace App\Services\Pos;

use Illuminate\Support\Str;

//Services
use App\Services\BaseServices;
use App\Services\Validation\Pos\CustomerValidation;

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
            return response(["message"=>'customer not found'],404);
        }
    }

    public function customerCreate($request){
        $fields = CustomerValidation::validate1($request);
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
            return response(["message"=>'Server Error'],404);
        }
    }

    public function customerUpdate($request, $id){
        $customer = $this->baseRI->findById($this->customerModel, $id);
        if($customer){
            $fields = CustomerValidation::validate1($request);
            $customer->update([
                'name' => $fields['name'],
                'phone' => $fields['phone'],
                'email' => $request->email,
                'address' => $request->address,
                'point' => $customer->point,
            ]);
            return response($customer,201);
        }else{
            return response(["message"=>'customer not found'],404);
        }
    }

    public function customerDelete($id){
        $customer = $this->baseRI->findById($this->customerModel, $id);
        if($customer){
            $customer->delete();
            return response(["message"=>'customer deleted successfully'],200);
        }else{
            return response(["message"=>'customer not found'],404);
        }
    }
}