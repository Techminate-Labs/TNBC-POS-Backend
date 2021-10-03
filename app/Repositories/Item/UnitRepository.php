<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\UnitRepositoryInterface;

//Models
use App\Models\Unit;

class UnitRepository implements UnitRepositoryInterface{

    public function unitSearch($query, $limit){
        return Unit::where('name', 'LIKE', '%' . $query . '%')
                ->withCount('item')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
    }

    public function unitList($limit){
        return Unit::withCount('item')
                ->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function unitGetById($id){
        return Unit::find($id);
    }

    public function unitCreate($data){
        return Unit::create($data);
    }
}