<?php

namespace App\Contracts\Item;

interface GeneralRepositoryInterface
{
    public function dataSearch($model, $query, $limit);
    public function dataList($model, $limit);
    public function dataGetById($model, $id);
    public function dataCreate($model, $data);
    public function supplierSearch($model, $query, $limit);
}