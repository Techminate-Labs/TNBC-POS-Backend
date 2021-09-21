<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Item\UnitServices;

class UnitController extends Controller
{
    private $unitServices;

    public function __construct(UnitServices $unitServices){
        $this->services = $unitServices;
    }

    public function unitList(Request $request)
    {
        return $this->services->unitList($request);
    }

    public function unitGetById($id)
    {
        return $this->services->unitGetById($id);
    }

    public function unitCreate(Request $request)
    {
        return $this->services->unitCreate($request);
    }

    public function unitUpdate(Request $request, $id)
    {
        return $this->services->unitUpdate($request, $id);
    }

    public function unitDelete($id)
    {
        return $this->services->unitDelete($id);
    }
}
