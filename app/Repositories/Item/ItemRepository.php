<?php

namespace App\Repositories\Item;
use Illuminate\Support\Facades\DB;

//Interface
use App\Contracts\Item\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface{

    //Check
    public function checkIfObj($propModel, $query){
        if($this->propObj($propModel, $query)){
            return true ;
        }else{
            return false ;
        }
    }

    //Get ID
    public function propObj($propModel, $query){
        $propObj = $propModel::where('name', 'LIKE', '%' . $query . '%')
                        ->first();
        return $propObj;
    }

    //Search
    public function filterByProp($model, $propModel, $query, $limit, $prop){
        $propObj = $this->propObj($propModel, $query);//category, brand etc
        $item = $model::where($prop, $propObj->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit);
        return $item;
    }
}