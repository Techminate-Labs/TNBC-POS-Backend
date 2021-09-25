<?php

namespace App\Services\Item;

//Interface
use App\Contracts\Item\ItemRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class ItemServices{
    
    private $repositoryInterface;

    public function __construct(ItemRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
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

    // public function itemList($request){
    //     if ($request->has('q')){
    //         $q = $request->q;
    //         if($this->ri->checkIfCategory($q)){
    //             $item = $this->ri->itemSearchByCategory($q);
    //         }elseif($this->ri->checkIfBrand($q)){
    //             $item = $this->ri->itemSearchByBrand($q);
    //         }elseif($this->ri->checkIfUnit($q)){
    //             $item = $this->ri->itemSearchByUnit($q);
    //         }elseif($this->ri->checkIfSupplier($q)){
    //             $item = $this->ri->itemSearchBySupplier($q);
    //         }else{
    //             $item = $this->ri->itemSearch($q);
    //         }
    //     }
    //     else{
    //         $item = $this->ri->itemList();
    //     }
    //     return new PaginationResource($item);
    // }

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
            'name'=>'required|string',
            'email'=>'email',
            'phone'=>'numeric',
            'company'=>'string',
        ]);

        $item = $this->ri->itemCreate([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'company' => $fields['company'],
        ]);

        return response($item,201);
    }

    public function itemUpdate($request, $id){
        $item = $this->ri->itemGetById($id);
        if($item){
            $data = $request->all();
            $fields = $request->validate([
                'name'=>'required|string',
                'email'=>'email',
                'phone'=>'numeric',
                'company'=>'string',
            ]);
            $item->update([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'phone' => $fields['phone'],
                'company' => $fields['company'],
            ]);
            return response($item,201);
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }

    public function itemDelete($id){
        $item = $this->ri->itemGetById($id);
        if($item){
            $item->delete();
            return response(["done"=>'item Deleted Successfully'],200);
        }else{
            return response(["failed"=>'item not found'],404);
        }
    }
}