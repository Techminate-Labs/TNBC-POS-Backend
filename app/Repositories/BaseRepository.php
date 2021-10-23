<?php

namespace App\Repositories;

//Interface
use App\Contracts\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface{

    public function storeInDB($model, $data){
        return $model::create($data);
    }

    public function findById($model, $id){
        return $model::where('id', $id)
                ->first();
    }

    public function listWithoutPagination($model, $limit){
        return $model::orderBy('created_at', 'desc')
                ->all();
    }

    public function listWithPagination($model, $limit){
        return $model::orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function listwithCount($model, $limit, $countObj){
        return $model::withCount($countObj)
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }
}