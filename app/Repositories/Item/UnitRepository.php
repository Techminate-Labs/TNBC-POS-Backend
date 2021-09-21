<?php

namespace App\Repositories\Item;

//Interface
use App\Contracts\Item\UnitRepositoryInterface;

//Models
use App\Models\Unit;

class UnitRepository implements UnitRepositoryInterface{

    public function unitSearch($query){
        return Unit::where('name', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
    }

    public function unitList(){
        return Unit::orderBy('created_at', 'desc')->paginate(4);
    }

    public function unitGetById($id){
        return Unit::find($id);
    }

    public function unitCreate($data){
        return Unit::create($data);
    }
}