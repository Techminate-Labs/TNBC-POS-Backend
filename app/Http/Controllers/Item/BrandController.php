<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Item\BrandServices;

class BrandController extends Controller
{
    private $brandServices;

    public function __construct(BrandServices $brandServices){
        $this->services = $brandServices;
    }

    public function brandList(Request $request)
    {
        return $this->services->brandList($request);
    }

    public function brandGetById($id)
    {
        return $this->services->brandGetById($id);
    }

    public function brandCreate(Request $request)
    {
        return $this->services->brandCreate($request);
    }

    public function brandUpdate(Request $request, $id)
    {
        return $this->services->brandUpdate($request, $id);
    }

    public function brandDelete($id)
    {
        return $this->services->brandDelete($id);
    }
}
