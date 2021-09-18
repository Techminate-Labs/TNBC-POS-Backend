<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Interface
use App\Contracts\Item\CategoryRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class CategoryServices{
    
    private $repositoryInterface;

    public function __construct(CategoryRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function categoryCreate($request){
        $fields = $request->validate([
            'name'=>'required|string|unique:categories,name',
        ]);

        $category = $this->ri->categoryCreate([
            'name' => $fields['name'],
            'slug' => Str::slug($fields['name'])
        ]);

        return response($category,201);
    }
}