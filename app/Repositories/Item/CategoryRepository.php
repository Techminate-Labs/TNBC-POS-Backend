<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\CategoryRepositoryInterface;

//Models
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface{

    public function categorySearch($query){
        return Category::where('name', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'slug', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
    }

    public function categoryList(){
        return Category::orderBy('created_at', 'desc')->paginate(5);
    }

    public function categoryGetById($id){
        return Category::find($id);
    }

    public function categoryCreate($data){
        return Category::create($data);
    }
}