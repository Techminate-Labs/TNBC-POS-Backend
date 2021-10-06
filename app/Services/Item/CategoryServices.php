<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

//Models
use App\Models\Category;

class CategoryServices{
    
    private $repositoryInterface;
    
    public function __construct(GeneralRepositoryInterface $generalRepositoryInterface){
        $this->ri = $generalRepositoryInterface;
        $this->model = Category::class;
    }

    public function categoryList($request){
        if ($request->has('q')){
            $category = $this->ri->dataSearch($this->model, $request->q, $request->limit);
        }else{
            $category = $this->ri->dataList($this->model, $request->limit);
        }
        return $category;
        // return new PaginationResource($category);
    }

    public function categoryGetById($id){
        $category = $this->ri->dataGetById($this->model, $id);
        if($category){
            return $category;
        }else{
            return response(["failed"=>'category not found'],404);
        }
    }

    public function categoryCreate($request){
        $fields = $request->validate([
            'name'=>'required|string|unique:categories,name',
        ]);

        $category = $this->ri->dataCreate(
            $this->model,
            [
                'name' => $fields['name'],
                'slug' => Str::slug($fields['name'])
            ]
        );

        return response($category,201);
    }

    public function categoryUpdate($request, $id){
        $category = $this->ri->dataGetById($this->model, $id);
        if($category){
            $data = $request->all();
            if($category->name==$data['name']){
                $fields = $request->validate([
                    'name'=>'required|string|max:255',
                ]);
            }
            else{
                $fields = $request->validate([
                    'name'=>'required|string|max:255|unique:categories,name',
                ]);
            }
            $data['slug'] = Str::slug($fields['name']);
            $category->update($data);
            return response($category,201);
        }else{
            return response(["failed"=>'Category not found'],404);
        }
    }

    public function categoryDelete($id){
        $category = $this->ri->dataGetById($this->model, $id);
        if($category){
            $category->delete();
            return response(["done"=>'category Deleted Successfully'],200);
        }else{
            return response(["failed"=>'category not found'],404);
        }
    }
}