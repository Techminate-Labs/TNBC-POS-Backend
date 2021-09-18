<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\CategoryRepositoryInterface;

//Models
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface{

    public function categoryCreate($data){
        return Category::create($data);
    }
}