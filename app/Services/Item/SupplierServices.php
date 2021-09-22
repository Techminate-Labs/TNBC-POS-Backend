<?php

namespace App\Services\Item;

//Interface
use App\Contracts\Item\SupplierRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class SupplierServices{
    
    private $repositoryInterface;

    public function __construct(SupplierRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function supplierList($request){
        if ($request->has('searchText')){
            $supplier = $this->ri->supplierSearch($request->searchText);
        }else{
            $supplier = $this->ri->supplierList();
        }
        return new PaginationResource($supplier);
    }

    public function supplierGetById($id){
        $supplier = $this->ri->supplierGetById($id);
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

        $supplier = $this->ri->supplierCreate([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'company' => $fields['company'],
        ]);

        return response($supplier,201);
    }

    public function supplierUpdate($request, $id){
        $supplier = $this->ri->supplierGetById($id);
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
        $supplier = $this->ri->supplierGetById($id);
        if($supplier){
            $supplier->delete();
            return response(["done"=>'supplier Deleted Successfully'],200);
        }else{
            return response(["failed"=>'supplier not found'],404);
        }
    }
}