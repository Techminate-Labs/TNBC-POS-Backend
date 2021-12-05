<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Services
use App\Services\BaseServices;

//Models
use App\Models\Category;

class CategoryServices extends BaseServices{
    
    private  $categoryModel = Category::class;

    public function categoryList($request){
        $countObj = 'item';
        $prop1 = 'name';
        if ($request->has('q')){
            $category = $this->filterRI->filterBy1PropWithCount($this->categoryModel, $request->q, $request->limit, $countObj, $prop1);
        }else{
            $category = $this->baseRI->listwithCount($this->categoryModel, $request->limit, $countObj);
        }
        return $category;
    }

    public function categoryGetById($id){
        $category = $this->baseRI->findById($this->categoryModel, $id);
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

        $category = $this->baseRI->storeInDB(
            $this->categoryModel,
            [
                'name' => $fields['name'],
                'slug' => Str::slug($fields['name'])
            ]
        );

        if($category){
            return response($category,201);
        }else{
            return response(["failed"=>'Server Error'],500);
        }
    }

    public function categoryUpdate($request, $id){
        $category = $this->baseRI->findById($this->categoryModel, $id);
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
        $category = $this->baseRI->findById($this->categoryModel, $id);
        if($category){
            $category->delete();
            return response(["done"=>'category Deleted Successfully'],200);
        }else{
            return response(["failed"=>'category not found'],404);
        }
    }
}