<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Item\SupplierServices;

class SupplierController extends Controller
{
    private $supplierServices;

    public function __construct(SupplierServices $supplierServices){
        $this->services = $supplierServices;
    }

    public function supplierList(Request $request)
    {
        return $this->services->supplierList($request);
    }

    public function supplierGetById($id)
    {
        return $this->services->supplierGetById($id);
    }

    public function supplierCreate(Request $request)
    {
        return $this->services->supplierCreate($request);
    }

    public function supplierUpdate(Request $request, $id)
    {
        return $this->services->supplierUpdate($request, $id);
    }

    public function supplierDelete($id)
    {
        return $this->services->supplierDelete($id);
    }
}