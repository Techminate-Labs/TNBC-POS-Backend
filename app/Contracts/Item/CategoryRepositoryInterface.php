<?php

namespace App\Contracts\Item;

interface CategoryRepositoryInterface
{
    public function dataSearch($model, $query, $limit);
    public function dataList($model, $limit);
    public function dataGetById($model, $id);
    public function dataCreate($model, $data);
}