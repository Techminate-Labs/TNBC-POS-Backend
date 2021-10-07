<?php

namespace App\Services\Item;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Models
use App\Models\Supplier;

class SupplierServices{
    
    private $repositoryInterface;

    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Supplier::class;
    }

    public function supplierList($request){
        if ($request->has('q')){
            $supplier = $this->ri->supplierSearch($this->model, $request->q, $request->limit);
        }else{
            $supplier = $this->ri->listwithCount($this->model, $request->limit);
        }
        return $supplier;
    }

    public function supplierGetById($id){
        $supplier = $this->ri->dataGetById($this->model, $id);
        if($supplier){
            return $supplier;
        }else{
            return response(["failed"=>'supplier not found'],404);
        }
    }

    public function supplierCreate($request){
        $fields = $request->validate([
            'name'=>'required|string',
            'email'=>'email',
            'phone'=>'numeric',
            'company'=>'string',
        ]);

        $supplier = $this->ri->dataCreate(
            $this->model,
            [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'company' => $fields['company'],
            ]
        );

        return response($supplier,201);
    }

    public function supplierUpdate($request, $id){
        $supplier = $this->ri->dataGetById($this->model, $id);
        if($supplier){
            $data = $request->all();
            $fields = $request->validate([
                'name'=>'required|string',
                'email'=>'email',
                'phone'=>'numeric',
                'company'=>'string',
            ]);
            $supplier->update([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'phone' => $fields['phone'],
                'company' => $fields['company'],
            ]);
            return response($supplier,201);
        }else{
            return response(["failed"=>'supplier not found'],404);
        }
    }

    public function supplierDelete($id){
        $supplier = $this->ri->dataGetById($this->model, $id);
        if($supplier){
            $supplier->delete();
            return response(["done"=>'supplier Deleted Successfully'],200);
        }else{
            return response(["failed"=>'supplier not found'],404);
        }
    }
}