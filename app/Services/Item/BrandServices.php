<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Interface
use App\Contracts\Item\BrandRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class BrandServices{
    
    private $repositoryInterface;

    public function __construct(BrandRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function brandList($request){
        if ($request->has('searchText')){
            $brand = $this->ri->brandSearch($request->searchText);
        }else{
            $brand = $this->ri->brandList();
        }
        return new PaginationResource($brand);
    }

    public function brandGetById($id){
        $brand = $this->ri->brandGetById($id);
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

        $brand = $this->ri->brandCreate([
            'name' => $fields['name'],
            'slug' => Str::slug($fields['name'])
        ]);

        return response($brand,201);
    }

    public function brandUpdate($request, $id){
        $fields = $request->validate([
            
        ]);

        $brand = $this->ri->brandGetById($id);
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
        $brand = $this->ri->brandGetById($id);
        if($brand){
            $brand->delete();
            return response(["done"=>'brand Deleted Successfully'],200);
        }else{
            return response(["failed"=>'brand not found'],404);
        }
    }
}