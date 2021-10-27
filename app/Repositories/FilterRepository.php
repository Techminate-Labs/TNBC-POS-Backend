<?php

namespace App\Repositories;

//Interface
use App\Contracts\FilterRepositoryInterface;

class FilterRepository implements FilterRepositoryInterface{

    public function filterBy1PropFirst($model, $query, $prop1){
        return $model::where($prop1, 'LIKE', '%' . $query . '%')
                ->first();
    }

    public function filterBy1Prop($model, $query, $prop1){
        return $model::where($prop1, 'LIKE', '%' . $query . '%')
                ->get();
    }

    public function filterBy1PropPaginated($model, $query, $limit, $prop1){
        return $model::where($prop1, 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function filterBy1PropWithCount($model, $query, $limit, $countObj, $prop1){
        return $model::where($prop1, 'LIKE', '%' . $query . '%')
                ->withCount($countObj)
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function filterBy4PropPaginated($model, $query, $limit, $prop1, $prop2, $prop3, $prop4){
        return $model::where($prop1, 'LIKE', '%' . $query . '%')
                ->orWhere($prop2, 'LIKE', '%' . $query . '%')
                ->orWhere($prop3, 'LIKE', '%' . $query . '%')
                ->orWhere($prop4, 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function filterBy4PropWithCount($model, $query, $limit, $countObj, $prop1, $prop2, $prop3, $prop4){
        return $model::where($prop1, 'LIKE', '%' . $query . '%')
                ->orWhere($prop2, 'LIKE', '%' . $query . '%')
                ->orWhere($prop3, 'LIKE', '%' . $query . '%')
                ->orWhere($prop4, 'LIKE', '%' . $query . '%')
                ->withCount($countObj)
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }
}