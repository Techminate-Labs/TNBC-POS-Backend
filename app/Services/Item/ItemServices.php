<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;
use App\Contracts\ItemRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

//Utilities
use App\Utilities\FileUtilities;

//Format
use App\Format\ItemFormat;

//Models
use App\Models\Item;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Supplier;

class ItemServices{
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;
    private $itemRepositoryInterface;
    private $fileUtilities;
    private $itemFormat;
    public static $imagePath = 'images/item';
    public static $explode_at = "item/";

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface,
        ItemRepositoryInterface $itemRepositoryInterface,
        FileUtilities $fileUtilities,
        ItemFormat $itemFormat
    ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->itemRI = $itemRepositoryInterface;
        $this->fileUtilities = $fileUtilities;
        $this->itemFormat = $itemFormat;

        $this->itemModel = Item::class;
        $this->categoryModel = Category::class;
        $this->brandModel = Brand::class;
        $this->unitModel = Unit::class;
        $this->supplierModel = Supplier::class;
    }

    public function randomItems($request){
        if($request->has('q')){
            return $this->filterRI->filterBy3Prop($this->itemModel, $request->q, 'name', 'slug', 'sku');
        }
        else{
            return $this->baseRI->listInRandomOrder($this->itemModel, 12);
        }
    }

    public function itemList($request){
        $limit = $request->limit;
        if($request->has('q')){
            $q = $request->q;
            switch (true) {
                case $this->itemRI->checkIfObj($this->categoryModel, $q):
                    $item = $this->itemRI->filterByProp($this->itemModel, $this->categoryModel, $q, $limit, 'category_id');
                    break;
                case $this->itemRI->checkIfObj($this->brandModel, $q):
                    $item = $this->itemRI->filterByProp($this->itemModel, $this->brandModel, $q, $limit, 'brand_id');
                    break;
                case $this->itemRI->checkIfObj($this->unitModel, $q):
                    $item = $this->itemRI->filterByProp($this->itemModel, $this->unitModel, $q, $limit, 'unit_id');
                    break;
                case $this->itemRI->checkIfObj($this->supplierModel, $q):
                    $item = $this->itemRI->filterByProp($this->itemModel, $this->supplierModel, $q, $limit, 'supplier_id');
                    break;
                default:
                    $item = $this->filterRI->filterBy4Prop($this->itemModel, $q, $limit, 'name', 'slug', 'sku', 'price');
            }
        }else{
            $item = $this->baseRI->listWithPagination($this->itemModel, $limit);
        }

        if($item){
            return $item->through(function($item){
                return $this->itemFormat->formatItemList($item);
               });
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }

    public function itemGetById($id){
        $item = $this->baseRI->findById($this->itemModel, $id);
        if($item){
            return $this->itemFormat->formatItemList($item);
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }

    public function itemCreate($request){
        $fields = $request->validate([
            'category_id'=>'required|numeric',
            'brand_id'=>'required|numeric',
            'unit_id'=>'required|numeric',
            'supplier_id'=>'required|numeric',
            'name'=>'required|string|unique:categories,name',
            'price'=>'required|numeric',
            'inventory'=>'required|numeric',
        ]);

        //image upload
        $image = $this->fileUtilities->fileUpload($request, url(''), self::$imagePath, false, false, false);
        $data = $request->all();
        $data['image'] = $image;

        $item = $this->baseRI->storeInDB(
            $this->itemModel,
            [
                'category_id' => $fields['category_id'],
                'brand_id' => $fields['brand_id'],
                'unit_id' => $fields['unit_id'],
                'supplier_id' => $fields['supplier_id'],
                'name' => $fields['name'],
                'slug' => Str::slug($fields['name']),
                'sku' => rand(1111,100000),
                'price' => $fields['price'],
                'discount' => $data['discount'],
                'inventory' => $fields['inventory'],
                'expire_date' => $data['expire_date'],
                'available' => $data['available'],
                'image' => $data['image']
            ]);

        if($item){
            return $this->itemFormat->formatItemList($item);
        }else{
            return [] ;
        }

        return response($item,201);
    }

    public function itemUpdate($request, $id){
        $item = $this->baseRI->findById($this->itemModel, $id);

        if($item){
            $fields = $request->validate([
                'category_id'=>'required|numeric',
                'brand_id'=>'required|numeric',
                'unit_id'=>'required|numeric',
                'supplier_id'=>'required|numeric',
                'name'=>'required|string|unique:categories,name',
                'price'=>'required|numeric',
                'inventory'=>'required|numeric',
            ]);

            $data = $request->all();
            //image upload
            $exImagePath = $item->image;
            $image = $this->fileUtilities->fileUpload($request, url(''), self::$imagePath, self::$explode_at, $exImagePath, true);
            $data['image'] = $image;

            $item->update([
                'category_id' => $fields['category_id'],
                'brand_id' => $fields['brand_id'],
                'unit_id' => $fields['unit_id'],
                'supplier_id' => $fields['supplier_id'],
                'name' => $fields['name'],
                'slug' => Str::slug($fields['name']),
                'price' => $fields['price'],
                'discount' => $data['discount'],
                'inventory' => $fields['inventory'],
                'expire_date' => $data['expire_date'],
                'available' => $data['available'],
                'image' => $data['image']
            ]);
            return response($item,201);
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }

    public function itemDelete($id){
        $item = $this->baseRI->findById($this->itemModel, $id);
        if($item){
            $item->delete();
            return response(["done"=>'item Deleted Successfully'],200);
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }
}