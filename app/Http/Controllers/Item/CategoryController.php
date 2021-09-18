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

    public function categoryCreate(Request $request)
    {
        return $this->services->categoryCreate($request);
    }

}
