<?php

namespace App\Repositories\Item;
use Illuminate\Support\Facades\DB;

//Interface
use App\Contracts\Item\ItemRepositoryInterface;

//Format
use App\Format\ItemFormat;

//Models
use App\Models\Item;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Supplier;

class ItemRepository implements ItemRepositoryInterface{

    public function __construct(ItemFormat $itemFormat){
        $this->itemFormat = $itemFormat;
    }
    
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
                        ->select('id')
                        ->first();
        return $propObj;
    }

    //Search
    public function filterByProp($model, $propModel, $query, $limit, $prop){
        $propObj = $this->propObj($propModel, $query);//category
        $item = $model::where($prop, $propObj->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit)
                    ->through(function($item){
                        return $this->itemFormat->formatItemList($item);
                    });

        return $item;
    }

    public function itemSearch($query, $limit){
        return Item::where('slug', 'LIKE', '%' . $query . '%')
                ->orWhere('name', 'LIKE', '%' . $query . '%')
                ->orWhere('sku', 'LIKE', '%' . $query . '%')
                ->orWhere('price', 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
                ->through(function($item){
                    return $this->itemFormat->formatItemList($item);
                });
    }

    public function itemList($limit){
        return Item::orderBy('created_at', 'desc')
                ->paginate($limit)
                ->through(function($item){
                    return $this->itemFormat->formatItemList($item);
                });

    if($item){
            return $this->itemFormat->formatItemList($item);
        }else{
            return [] ;
        }
    }

    public function itemGetById($id){
        $item = Item::where('id',$id)
                ->first();
        if($item){
            return $this->itemFormat->formatItemList($item);
        }else{
            return [] ;
        }
    }

    public function itemFindById($id){
        return Item::find($id);
    }

    public function randomItems(){
        return Item::inRandomOrder()->limit(12)->get();
    }

    //Commands
    public function itemCreate($data){
        $item = Item::create($data);
        if($item){
            return $this->itemFormat->formatItemList($item);
        }else{
            return [] ;
        }
    }
}