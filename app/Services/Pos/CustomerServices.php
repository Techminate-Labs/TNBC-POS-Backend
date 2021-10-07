<?php

namespace App\Services\Pos;

use Illuminate\Support\Str;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

//Models
use App\Models\Customer;

class CustomerServices{
    
    private $repositoryInterface;
    
    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Customer::class;
    }

    public function customerList($request){
        if ($request->has('q')){
            $customer = $this->ri->customerSearch($this->model, $request->q, $request->limit);
        }else{
            $customer = $this->ri->list($this->model, $request->limit);
        }
        return $customer;
    }

    public function customerGetById($id){
        $customer = $this->ri->dataGetById($this->model, $id);
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
        $customer = $this->ri->dataCreate(
            $this->model,
            [
                'name' => $fields['name'],
                'phone' => $fields['phone'],
                'email' => $request->email,
                'address' => $request->address,
                'point' => 0,
            ]
        );

        return response($customer,201);
    }

    public function customerUpdate($request, $id){
        $customer = $this->ri->dataGetById($this->model, $id);
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
        $customer = $this->ri->dataGetById($this->model, $id);
        if($customer){
            $customer->delete();
            return response(["done"=>'customer Deleted Successfully'],200);
        }else{
            return response(["failed"=>'customer not found'],404);
        }
    }
}