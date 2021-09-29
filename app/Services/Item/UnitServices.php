<?php

namespace App\Services\Item;

//Interface
use App\Contracts\Item\UnitRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class UnitServices{
    
    private $repositoryInterface;

    public function __construct(UnitRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function unitList($request){
        if ($request->has('searchText')){
            $unit = $this->ri->unitSearch($request->searchText, $request->limit);
        }else{
            $unit = $this->ri->unitList($request->limit);
        }
        return new PaginationResource($unit);
    }

    public function unitGetById($id){
        $unit = $this->ri->unitGetById($id);
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

        $unit = $this->ri->unitCreate([
            'name' => $fields['name'],
        ]);

        return response($unit,201);
    }

    public function unitUpdate($request, $id){
        $unit = $this->ri->unitGetById($id);
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
        $unit = $this->ri->unitGetById($id);
        if($unit){
            $unit->delete();
            return response(["done"=>'unit Deleted Successfully'],200);
        }else{
            return response(["failed"=>'unit not found'],404);
        }
    }
}