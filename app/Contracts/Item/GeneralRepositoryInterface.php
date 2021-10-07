<?php

namespace App\Contracts\Item;

interface GeneralRepositoryInterface
{
    public function list($model, $limit);
    public function listwithCount($model, $limit);
    public function dataGetById($model, $id);
    public function dataCreate($model, $data);
    public function dataSearch($model, $query, $limit);
    public function supplierSearch($model, $query, $limit);
    public function customerSearch($model, $query, $limit);
}