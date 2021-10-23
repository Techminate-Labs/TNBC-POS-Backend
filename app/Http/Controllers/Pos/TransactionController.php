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
        $url = 'http://54.183.16.194/bank_transactions?recipient=a5dbcded3501291743e0cb4c6a186afa2c87a54f4a876c620dbd68385cba80d0';
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

    public function testApi(){
        $url = 'http://54.183.16.194/bank_transactions?recipient=a5dbcded3501291743e0cb4c6a186afa2c87a54f4a876c620dbd68385cba80d0';
        $fetch = Http::get($url);
        $data = json_decode($fetch);
        // $results = $data['results'][1]['memo'];
        $results = $data->results;

        $transactions = [];
        $date = [];
        foreach($results as $result){
            $amount = $result->amount;
            $block = $result->block->created_date;
            array_push($transactions, $amount);
            array_push($date, $block);
            
        }
        // return $data;
        $response = [
            'transactions' => $transactions,
            'date' => $date
        ];
        return response($response, 200);
    }
    
}
