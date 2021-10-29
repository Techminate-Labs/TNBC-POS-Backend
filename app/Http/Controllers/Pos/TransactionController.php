<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    public function transactionHistory(){
        $url = 'http://54.183.16.194/bank_transactions?recipient=a5dbcded3501291743e0cb4c6a186afa2c87a54f4a876c620dbd68385cba80d0&fee=NONE';
        $fetch = Http::get($url);
        $data = json_decode($fetch);
        $results = $data->results;

        $collection = new Collection($results);
        $formattedList = $collection->map(function($result, $key){
            return $this->formatList($result);
        });

        $lastTransactionAmount = $formattedList[0]['amount'];
        $lastSenderPK = $formattedList[0]['sender'];
        $tableData = $this->paginate($formattedList);

        $response = [
            'lastTransactionAmount' => $lastTransactionAmount,
            'lastSenderPK' => $lastSenderPK,
            'tableData' => $tableData
        ];

        return response($response, 200);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function formatList($result){
        return[
            'date' => $result->block->created_date,
            'sender' => $result->block->sender,
            'amount' => $result->amount,
            'memo'=>$result->memo
        ];
    }

    public function treasury(){
        $url = 'http://54.183.16.194/bank_transactions?account_number=23676c35fce177aef2412e3ab12d22bf521ed423c6f55b8922c336500a1a27c5&fee=NONE';
        $fetch = Http::get($url);
        $data = json_decode($fetch);
        $results = $data->results;
        // return $results;
        $transactions = [];
        $total = 0;
        foreach($results as $result){
            $amount = $result->amount;
            if($amount == 1){
                continue;
            }
            $obj = [
                "transactions"=>$amount,
            ];
            array_push($transactions, $obj);
            $total = $total + $amount; 
        }
        
        $response = [
            'total_treasury_withdrawals' => $total,
            'transactions' => $transactions,
        ];
        return response($response, 200);
    }

    public function atm(Request $request){
        $block = [];
        $day = $request->day;
        $invest = $request->invest;
        $rate = $request->rate;
        $rateIncreamentBy = $request->increament;
        $totalCrypto = 0;
        $totalInvest = 0;
        for($i = 1; $i<= $day; $i++){
            $tnbc = $invest/$rate;
            $totalCrypto = $totalCrypto + $tnbc;
            
            $totalInvest = $totalInvest + $invest;
            $obj = [
                "day"=>$i,
                "invest"=>$invest,
                "rate"=>(round($rate, 4)),
                "tnbc"=>(round($tnbc, 2)),
                "totalCrypto"=>(round($totalCrypto, 2)),
                "totalInvest"=>$totalInvest
            ];

            array_push($block, $obj);
            $rate = $rate + $rateIncreamentBy;
        }
        return $block;
    }

    public function ats(Request $request){
        $day = $request->day;
        $n = $day - 1;
        $blocks = $this->atm($request);
        $block = $blocks[$n];
        $rate = $block['rate'];
        $totalCrypto = $block['totalCrypto'];
        $totalInvest = $block['totalInvest'];

        $salePrice = $rate * $totalCrypto;
        $profit = $salePrice - $totalInvest;

        $obj = [
            "day"=>$day,
            "rate"=>$rate,
            "totalInvest"=>$totalInvest,
            "totalCrypto"=>$totalCrypto,
            "salePrice"=>(round($salePrice, 2)),
            "profit"=>(round($profit, 2)),
            "plans" => $blocks
        ];
        return $obj;
    }
}
