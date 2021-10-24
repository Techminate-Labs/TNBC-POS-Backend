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

    //Get Id
    public function itemCategory($query){
        $category = Category::where('name', 'LIKE', '%' . $query . '%')
                        ->select('id')
                        ->first();
        return $category;
    }

    public function itemBrand($query){
        $brand = Brand::where('name', 'LIKE', '%' . $query . '%')
                        ->select('id')
                        ->first();
        return $brand;
    }

    public function itemUnit($query){
        $unit = Unit::where('name', 'LIKE', '%' . $query . '%')
                        ->select('id')
                        ->first();
        return $unit;
    }

    public function itemSupplier($query){
        $supplier = Supplier::where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('company', 'LIKE', '%' . $query . '%')
                        ->select('id')
                        ->first();
        return $supplier;
    }

    //Check
    public function checkIfCategory($query){
        if($this->itemCategory($query)){
            return true ;
        }else{
            return false ;
        }
    }

    public function checkIfBrand($query){
        if($this->itemBrand($query)){
            return true ;
        }else{
            return false ;
        }
    }

    public function checkIfUnit($query){
        if($this->itemUnit($query)){
            return true ;
        }else{
            return false ;
        }
    }

    public function checkIfSupplier($query){
        if($this->itemSupplier($query)){
            return true ;
        }else{
            return false ;
        }
    }

    //Search
    public function itemSearchByCategory($query, $limit){
        $category = $this->itemCategory($query);
        return Item::where('category_id', $category->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit)
                    ->through(function($item){
                        return $this->itemFormat->formatItemList($item);
                    });
    }

    public function itemSearchByBrand($query, $limit){
        $brand = $this->itemBrand($query);
        return Item::where('brand_id', $brand->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit)
                    ->through(function($item){
                        return $this->itemFormat->formatItemList($item);
                    });
    }

    public function itemSearchByUnit($query, $limit){
        $unit = $this->itemUnit($query);
        return Item::where('unit_id', $unit->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit)
                    ->through(function($item){
                        return $this->itemFormat->formatItemList($item);
                    });
    }

    public function itemSearchBySupplier($query, $limit){
        $supplier = $this->itemSupplier($query);
        return Item::where('supplier_id', $supplier->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit)
                    ->through(function($item){
                        return $this->itemFormat->formatItemList($item);
                    });
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