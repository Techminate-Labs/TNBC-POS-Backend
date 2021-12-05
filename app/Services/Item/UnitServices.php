<?php

namespace App\Services\Item;

//Services
use App\Services\BaseServices;

//Models
use App\Models\Unit;

class UnitServices extends BaseServices{
    
    private $unitModel = Unit::class;

    public function unitList($request){
        $countObj = 'item';
        $prop1 = 'name';
        if ($request->has('q')){
            $unit = $this->filterRI->filterBy1PropWithCount($this->unitModel, $request->q, $request->limit, $countObj, $prop1);
        }else{
            $unit = $this->baseRI->listwithCount($this->unitModel, $request->limit, $countObj);
        }
        return $unit;
    }

    public function unitGetById($id){
        $unit = $this->baseRI->findById($this->unitModel, $id);
        if($unit){
            return $unit;
        }else{
            return response(["failed"=>'unit not found'],404);
        }
    }

    public function unitCreate($request){
        $fields = $request->validate([
            'name'=>'required|string|unique:units,name',
        ]);

        $unit = $this->baseRI->storeInDB(
            $this->unitModel,
            [
                'name' => $fields['name'],
            ]
        );

        if($unit){
            return response($unit,201);
        }else{
            return response(["failed"=>'Server Error'],500);
        }
    }

    public function unitUpdate($request, $id){
        $unit = $this->baseRI->findById($this->unitModel, $id);
        if($unit){
            $data = $request->all();
            if($unit->name==$data['name']){
                $fields = $request->validate([
                    'name'=>'required|string|max:255',
                ]);
            }
            else{
                $fields = $request->validate([
                    'name'=>'required|string|max:255|unique:units,name',
                ]);
            }
            $unit->update($data);
            return response($unit,201);
        }else{
            return response(["failed"=>'unit not found'],404);
        }
    }

    public function unitDelete($id){
        $unit = $this->baseRI->findById($this->unitModel, $id);
        if($unit){
            $unit->delete();
            return response(["done"=>'unit Deleted Successfully'],200);
        }else{
            return response(["failed"=>'unit not found'],404);
        }
    }
}