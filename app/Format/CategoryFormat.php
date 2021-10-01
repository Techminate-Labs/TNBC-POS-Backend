<?php

namespace App\Format;

class CategoryFormat{
    public function formatCategoryList($category){
        return[
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'num_of_items' => $category->item_count,
            'created_at'=>$category->created_at->diffForHumans(),
            'updated_at'=>$category->updated_at->diffForHumans()
        ];
    }
}