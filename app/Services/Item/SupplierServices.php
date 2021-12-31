<?php

namespace App\Services\Item;

//Services
use App\Services\BaseServices;
use App\Services\Validation\Item\SupplierValidation;

//Models
use App\Models\Supplier;

class SupplierServices extends BaseServices{
    
    private $supplierModel = Supplier::class;

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
            return response(["message"=>'supplier not found'],404);
        }
    }

    public function supplierCreate($request){
        $fields = SupplierValidation::validate1($request);
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
            return response(["message"=>'Server Error'],500);
        }
    }

    public function supplierUpdate($request, $id){
        $supplier = $this->baseRI->findById($this->supplierModel, $id);
        if($supplier){
            $fields = SupplierValidation::validate1($request);
            $supplier->update([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'phone' => $fields['phone'],
                'company' => $fields['company'],
            ]);
            return response($supplier,201);
        }else{
            return response(["message"=>'supplier not found'],404);
        }
    }

    public function supplierDelete($id){
        $supplier = $this->baseRI->findById($this->supplierModel, $id);
        if($supplier){
            $supplier->delete();
            return response(["message"=>'supplier Deleted Successfully'],200);
        }else{
            return response(["message"=>'supplier not found'],404);
        }
    }
}