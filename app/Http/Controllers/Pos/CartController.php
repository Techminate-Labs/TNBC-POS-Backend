<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

//Service
use App\Services\Pos\CartServices;

class CartController extends Controller
{
    private $cartServices;

    public function __construct(CartServices $cartServices){
        $this->services = $cartServices;
    }

    public function cartAddCustomer(Request $request)
    {
        return $this->services->cartAddCustomer($request);
    }

    public function testApi(){
        $url = 'http://54.183.16.194/bank_transactions?recipient=a5dbcded3501291743e0cb4c6a186afa2c87a54f4a876c620dbd68385cba80d0';
        $fetch = Http::get($url);
        $data = json_decode($fetch, true);
        // $results = $data['results'][1]['memo'];
        $results = $data['results'];
        $temp = [];
        foreach($results as $result){
            $memo = $result['memo'];
            array_push($temp, $memo);
            $temp[] = $memo;
        }
        // return $data;
        // return $results;
        return $temp;
    }
}
