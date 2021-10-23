<?php

namespace App\Services\Item;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

//Models
use App\Models\Supplier;

class SupplierServices{
    
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->supplierModel = Supplier::class;
    }

    public function supplierList($request){
        $countObj = 'item';
        $prop1 = 'name';
        $prop2 = 'email';
        $prop3 = 'phone';
        $prop4 = 'company';
        if ($request->has('q')){
            $supplier = $this->filterRI->filterBy4PropWithCount(
                $this->supplierModel, $request->q, $request->limit, $countObj,
                $prop1, $prop2, $prop3, $prop4);
        }else{
            $supplier = $this->baseRI->listwithCount($this->supplierModel, $request->limit, $countObj);
        }
        return $supplier;
    }

    public function supplierGetById($id){
        $supplier = $this->baseRI->findById($this->supplierModel, $id);
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

        $supplier = $this->baseRI->storeInDB(
            $this->supplierModel,
            [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'company' => $fields['company'],
            ]
        );

        if($supplier){
            return response($supplier,201);
        }else{
            return response(["failed"=>'Server Error'],500);
        }
    }

    public function supplierUpdate($request, $id){
        $supplier = $this->baseRI->findById($this->supplierModel, $id);
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
        $supplier = $this->baseRI->findById($this->supplierModel, $id);
        if($supplier){
            $supplier->delete();
            return response(["done"=>'supplier Deleted Successfully'],200);
        }else{
            return response(["failed"=>'supplier not found'],404);
        }
    }
}