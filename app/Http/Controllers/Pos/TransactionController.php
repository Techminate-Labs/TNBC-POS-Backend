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

    public function lineChart(){
        $url = 'http://54.183.16.194/bank_transactions?limit=20&recipient=22d0f0047b572a6acb6615f7aae646b0b96ddc58bfd54ed2775f885baeba3d6a';
        $fetch = Http::get($url);
        $data = json_decode($fetch);
        $results = $data->results;
        
        // return $results;
        $collection = new Collection($results);
        $formattedList = $collection->map(function($result, $key){
            $str = $result->block->created_date;
            $split = explode('T',$str);
            return[
                'date' => $split[0] ,
                'amount' => $result->amount
            ];
        });

        $count = count($formattedList);
        for ($i = 0; $i <= $count; $i++) {
            $date = $formattedList[$i]['date'];
            $amount = $formattedList[$i]['amount'];
            echo $amount;
        }
        

        // return $formattedList;

        // [
        //     {
        //         "date": "2021-10-07",
        //         "amount": 21
        //     },
        //     {
        //         "date": "2021-10-07",
        //         "amount": 477
        //     },
        //     {
        //         "date": "2021-10-06",
        //         "amount": 3
        //     },
        // ]

        // [
        //     {
        //         "date": "2021-10-07",
        //         "amount": 687
        //     },
        //     {
        //         "date": "2021-10-06",
        //         "amount": 3
        //     },
        // ]

        $formatted = collect($formattedList)
        ->groupBy('date')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        });

        return $formatted;

        $response = [
            'transactions' => $transactions,
            'date' => $date
        ];
        return response($response, 200);
    }

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
    
}
