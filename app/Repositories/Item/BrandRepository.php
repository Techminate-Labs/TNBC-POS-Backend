<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\BrandRepositoryInterface;

//Models
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface{

    public function brandSearch($query, $limit){
        return Brand::where('name', 'LIKE', '%' . $query . '%')
                ->withCount('item')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function brandList($limit){
        return Brand::withCount('item')
                ->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function brandGetById($id){
        return Brand::find($id);
    }

    public function brandCreate($data){
        return Brand::create($data);
    }
}