<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Models
use App\Models\Brand;

class BrandServices{
    
    private $repositoryInterface;

    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Brand::class;
    }

    public function brandList($request){
        if ($request->has('q')){
            $brand = $this->ri->dataSearch($this->model, $request->q, $request->limit);
        }else{
            $brand = $this->ri->listwithCount($this->model, $request->limit);
        }
        return $brand;
    }

    public function brandGetById($id){
        $brand = $this->ri->dataGetById($this->model, $id);
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

        $brand = $this->ri->dataCreate(
            $this->model,
            [
                'name' => $fields['name'],
                'slug' => Str::slug($fields['name'])
            ]
        );

        return response($brand,201);
    }

    public function brandUpdate($request, $id){
        $brand = $this->ri->dataGetById($this->model, $id);
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
        $brand = $this->ri->dataGetById($this->model, $id);
        if($brand){
            $brand->delete();
            return response(["done"=>'brand Deleted Successfully'],200);
        }else{
            return response(["failed"=>'brand not found'],404);
        }
    }
}