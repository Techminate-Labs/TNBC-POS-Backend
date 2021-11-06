<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blockchainController extends Controller
{
    public function __construct($index, $timestamp, $data, $previousHash=''){
        $this->$index = $index;
        $this->$timestamp = $timestamp;
        $this->$data = $data;
        $this->$previousHash = $previousHash;
        $this->hash = '';
    }

    public function calculateHash(){
        $hash = $this->$index + $this->$timestamp + $this->$previousHash + $this->$data;
        return hash('sha256', );
    }

    
    public function treasury()
    {
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

    public function graph()
    {
        $url = 'http://54.183.16.194/bank_transactions?account_number=6e5ea8507e38be7250cde9b8ff1f7c8e39a1460de16b38e6f4d5562ae36b5c1a&fee=NONE&limit=20';
        $fetch = Http::get($url);
        $data = json_decode($fetch);
        $results = $data->results;
        $transactions = [];
        foreach($results as $result){
            $date = explode("T",$result->block->created_date);
            $amount = 0;
            foreach($results as $txs){
                $txsDate = explode("T",$txs->block->created_date);
                if($date[0] == $txsDate[0]){
                    $amount = $amount + $txs->amount;
                }
            }
            $obj = [
                "amount"=>$amount,
                "date"=>$date[0],
            ];
            array_push($transactions, $obj);
        }
        
        $response = [
            'transactions' => $transactions,
        ];
        return response($response, 200);
    }

    public function atm(Request $request)
    {
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

    public function ats(Request $request)
    {
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
