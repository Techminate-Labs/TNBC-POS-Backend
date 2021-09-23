<?php

namespace App\Repositories\Item;

use Illuminate\Database\Eloquent\Builder;

//Interface
use App\Contracts\Item\ItemRepositoryInterface;

//Format
use App\Format\ItemFormat;

//Models
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface{

    public function __construct(ItemFormat $itemFormat){
        $this->itemFormat = $itemFormat;
    }

    public function itemSearch($query){
        return Item::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('sku', 'LIKE', '%' . $query . '%')
                
                ->select('id', 'category_id', 'brand_id', 'unit_id',
                        'supplier_id','name', 'slug', 'sku', 'price', 
                        'discount_price', 'inventory', 'expire_date', 
                        'available','image', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->with('category')
                ->with('brand')
                ->with('unit')
                ->with('supplier')
                ->paginate(5)
                ->through(function($item){
                    return $this->itemFormat->formatItemList($item);
                });
    }

    public function itemList(){
        return Item::orderBy('created_at', 'desc')
                ->with('category')
                ->with('brand')
                ->with('unit')
                ->with('supplier')
                ->paginate(5)
                ->through(function($item){
                    return $this->itemFormat->formatItemList($item);
                });
    }

    public function itemGetById($id){
        return Item::find($id);
    }

    public function itemCreate($data){
        return Item::create($data);
    }
}