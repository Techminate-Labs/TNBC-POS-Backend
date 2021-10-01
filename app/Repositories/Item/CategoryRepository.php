<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\CategoryRepositoryInterface;

//Models
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface{

    public function categorySearch($query, $limit){
        return Category::where('name', 'LIKE', '%' . $query . '%')
                ->withCount('item')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function categoryList($limit){
        return Category::withCount('item')
                ->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function categoryGetById($id){
        return Category::find($id);
    }

    public function categoryCreate($data){
        return Category::create($data);
    }
}