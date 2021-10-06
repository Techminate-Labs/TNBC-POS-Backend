<?php

namespace App\Services\Item;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Models
use App\Models\Unit;

class UnitServices{
    
    private $repositoryInterface;

    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Unit::class;
    }

    public function unitList($request){
        if ($request->has('q')){
            $unit = $this->ri->dataSearch($this->model, $request->q, $request->limit);
        }else{
            $unit = $this->ri->dataList($this->model, $request->limit);
        }
        return $unit;
    }

    public function unitGetById($id){
        $unit = $this->ri->dataGetById($this->model, $id);
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

        $unit = $this->ri->dataCreate(
            $this->model,
            [
                'name' => $fields['name'],
            ]
        );

        return response($unit,201);
    }

    public function unitUpdate($request, $id){
        $unit = $this->ri->dataGetById($this->model, $id);
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
        $unit = $this->ri->dataGetById($this->model, $id);
        if($unit){
            $unit->delete();
            return response(["done"=>'unit Deleted Successfully'],200);
        }else{
            return response(["failed"=>'unit not found'],404);
        }
    }
}