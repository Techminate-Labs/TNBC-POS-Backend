<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Services
use App\Services\BaseServices;

//Models
use App\Models\Brand;

class BrandServices extends BaseServices{
    
    private $brandModel = Brand::class;

    public function brandList($request){
        $countObj = 'item';
        $prop1 = 'name';
        if ($request->has('q')){
            $brand = $this->filterRI->filterBy1PropWithCount($this->brandModel, $request->q, $request->limit, $countObj, $prop1);
        }else{
            $brand = $this->baseRI->listwithCount($this->brandModel, $request->limit, $countObj);
        }
        return $brand;
    }

    public function brandGetById($id){
        $brand = $this->baseRI->findById($this->brandModel, $id);
        if($brand){
            return $brand;
        }else{
            return response(["failed"=>'brand not found'],404);
        }
    }

    public function brandCreate($request){
        $fields = $request->validate([
            'name'=>'required|string|unique:brands,name',
        ]);

        $brand = $this->baseRI->storeInDB(
            $this->brandModel,
            [
                'name' => $fields['name'],
                'slug' => Str::slug($fields['name'])
            ]
        );

        return response($brand,201);
    }

    public function brandUpdate($request, $id){
        $brand = $this->baseRI->findById($this->brandModel, $id);
        if($brand){
            $data = $request->all();
            if($brand->name==$data['name']){
                $fields = $request->validate([
                    'name'=>'required|string|max:255',
                ]);
            }
            else{
                $fields = $request->validate([
                    'name'=>'required|string|max:255|unique:brands,name',
                ]);
            }
            $data['slug'] = Str::slug($fields['name']);
            $brand->update($data);
            return response($brand,201);
        }else{
            return response(["failed"=>'brand not found'],404);
        }
    }

    public function brandDelete($id){
        $brand = $this->baseRI->findById($this->brandModel, $id);
        if($brand){
            $brand->delete();
            return response(["done"=>'brand Deleted Successfully'],200);
        }else{
            return response(["failed"=>'brand not found'],404);
        }
    }
}