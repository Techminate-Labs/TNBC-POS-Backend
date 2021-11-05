<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Item\ItemServices;

class ItemController extends Controller
{
    private $itemServices;

    public function __construct(ItemServices $itemServices){
        $this->services = $itemServices;
    }

    public function searchItems(Request $request){
        return $this->services->searchItems($request);
    }

    public function randomItems(){
       return $this->services->randomItems();
    }

    public function itemList(Request $request)
    {
        return $this->services->itemList($request);
    }

    public function itemGetById($id)
    {
        return $this->services->itemGetById($id);
    }

    public function itemCreate(Request $request)
    {
        return $this->services->itemCreate($request);
    }

    public function itemUpdate(Request $request, $id)
    {
        return $this->services->itemUpdate($request, $id);
    }

    public function itemDelete($id)
    {
        return $this->services->itemDelete($id);
    }
}
