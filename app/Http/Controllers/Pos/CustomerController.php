<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Pos\CustomerServices;

class CustomerController extends Controller
{
    private $customerServices;

    public function __construct(CustomerServices $customerServices){
        $this->services = $customerServices;
    }

    public function customerList(Request $request)
    {
        return $this->services->customerList($request);
    }

    public function customerGetById($id)
    {
        return $this->services->customerGetById($id);
    }

    public function customerCreate(Request $request)
    {
        return $this->services->customerCreate($request);
    }

    public function customerUpdate(Request $request, $id)
    {
        return $this->services->customerUpdate($request, $id);
    }

    public function customerDelete($id)
    {
        return $this->services->customerDelete($id);
    }
}
