<?php

namespace App\Services\Pos;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

//Interface
use App\Contracts\BaseRepositoryInterface;

//Models
use App\Models\Configuration;

class TransactionServices{
    private $baseRepositoryInterface;
    private $configModel = Configuration::class;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface
    ){
        $this->baseRI = $baseRepositoryInterface;
    }

    public function transactionHistory()
    {
        $configuration = $this->baseRI->findById($this->configModel, 1);
        $pk = $configuration->tnbc_pk;
        $protocol = 'http';
        $bank = '54.183.16.194';
        $url = $protocol.'://'.$bank.'/bank_transactions?recipient='.$pk.'&limit=30&fee=NONE';
        
        $fetch = Http::get($url);
        $data = json_decode($fetch);
        $results = $data->results;

        $collection = new Collection($results);
        $formattedList = $collection->map(function($result, $key){
            return[
                'date' => $result->block->created_date,
                'sender' => $result->block->sender,
                'amount' => $result->amount,
                'memo'=>$result->memo
            ];
        });

        $tableData = $this->paginate($formattedList);

        $response = [
            'storePK' => $pk,
            'lastSenderPK' => $formattedList[0]['sender'],
            'lastTransactionAmount' => $formattedList[0]['amount'],
            'lastTransactionMemo' => $formattedList[0]['memo'],
            'tableData' => $tableData
        ];

        return response($response, 200);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}