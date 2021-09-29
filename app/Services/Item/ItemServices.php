<?php

namespace App\Services\Item;

use Illuminate\Support\Str;

//Interface
use App\Contracts\Item\ItemRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

//Utilities
use App\Utilities\FileUtilities;

class ItemServices{
    
    private $repositoryInterface;
    private $fileUtilities;
    public static $imagePath = 'images/item';
    public static $explode_at = "item/";

    public function __construct(
        ItemRepositoryInterface $repositoryInterface,
        FileUtilities $fileUtilities){
        $this->ri = $repositoryInterface;
        $this->fileUtilities = $fileUtilities;
    }

    public function itemList($request){
        
        if($request->has('q')){
            $q = $request->q;
            switch (true) {
                case $this->ri->checkIfCategory($q):
                    $item = $this->ri->itemSearchByCategory($q);
                    break;
                case $this->ri->checkIfBrand($q):
                    $item = $this->ri->itemSearchByBrand($q);
                    break;
                case $this->ri->checkIfUnit($q):
                    $item = $this->ri->itemSearchByUnit($q);
                    break;
                case $this->ri->checkIfSupplier($q):
                    $item = $this->ri->itemSearchBySupplier($q);
                    break;
                default:
                    $item = $this->ri->itemSearch($q);
            }
        }else{
            $item = $this->ri->itemList();
        }
        return new PaginationResource($item);
    }

    public function itemGetById($id){
        $item = $this->ri->itemGetById($id);
        if($item){
            return $item;
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

        $item = $this->ri->itemCreate([
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

        return response($item,201);
    }

    public function itemUpdate($request, $id){
        $item = $this->ri->itemFindById($id);

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
        $item = $this->ri->itemFindById($id);
        if($item){
            $item->delete();
            return response(["done"=>'item Deleted Successfully'],200);
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }
}