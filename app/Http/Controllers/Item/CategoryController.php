<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Item\CategoryServices;

class CategoryController extends Controller
{
    private $categoryServices;

    public function __construct(CategoryServices $categoryServices){
        $this->services = $categoryServices;
    }

    public function categoryList(Request $request)
    {
        return $this->services->categoryList($request);
    }

    public function categoryGetById($id)
    {
        return $this->services->categoryGetById($id);
    }

    public function categoryCreate(Request $request)
    {
        return $this->services->categoryCreate($request);
    }

    public function categoryUpdate(Request $request, $id)
    {
        return $this->services->categoryUpdate($request, $id);
    }

    public function categoryDelete($id)
    {
        return $this->services->categoryDelete($id);
    }
}
