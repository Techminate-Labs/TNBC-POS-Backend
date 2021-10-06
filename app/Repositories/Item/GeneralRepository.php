<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\GeneralRepositoryInterface;

class GeneralRepository implements GeneralRepositoryInterface{

    public function dataSearch($model, $query, $limit){
        return $model::where('name', 'LIKE', '%' . $query . '%')
                ->withCount('item')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function dataList($model, $limit){
        return $model::withCount('item')
                ->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function dataGetById($model, $id){
        return $model::find($id);
    }

    public function dataCreate($model, $data){
        return $model::create($data);
    }

    public function supplierSearch($model, $query, $limit){
        return $model::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%')
                ->orWhere('phone', 'LIKE', '%' . $query . '%')
                ->orWhere('company', 'LIKE', '%' . $query . '%')
                ->withCount('item')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }
}