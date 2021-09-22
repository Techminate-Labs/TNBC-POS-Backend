<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\BrandRepositoryInterface;

//Models
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface{

    public function brandSearch($query){
        return Brand::where('name', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'slug', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
    }

    public function brandList(){
        return Brand::orderBy('created_at', 'desc')->paginate(5);
    }

    public function brandGetById($id){
        return Brand::find($id);
    }

    public function brandCreate($data){
        return Brand::create($data);
    }
}