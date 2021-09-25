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

class ItemRepository implements ItemRepositoryInterface{

    public function __construct(ItemFormat $itemFormat){
        $this->itemFormat = $itemFormat;
    }

    public function itemSearch($query){
        return Item::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('sku', 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->through(function($item){
                    return $this->itemFormat->formatItemList($item);
                });
    }

    public function itemSearchByCategory($query){
        $id = $this->itemCategoryId($query);
        return Item::where('category_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(5)
                    ->through(function($item){
                        return $this->itemFormat->formatItemList($item);
                    });
    }

    public function itemList(){
        return Item::orderBy('created_at', 'desc')
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

    public function itemCategoryId($query){
        $category = Category::where('name', 'LIKE', '%' . $query . '%')
                        ->select('id')
                        ->first();
        return $category->id;
    }

    // public function itemSearchByCategory($query){
    //     $id = $this->itemCategoryId($query);
    //     return Category::find($id)->item()
    //             ->orderBy('created_at', 'desc')
    //             ->paginate(5)
    //             ->through(function($item){
    //                 return $this->itemFormat->formatItemList($item);
    //             });
    // }
}