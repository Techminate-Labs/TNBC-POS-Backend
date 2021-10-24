<?php

namespace App\Contracts\Item;

interface ItemRepositoryInterface
{
    //Query
    public function checkIfObj($propModel, $query);
    public function filterByProp($model, $propModel, $query, $limit, $prop);
   
    public function itemSearch($query, $limit);
    public function itemList($limit);
    public function itemGetById($id);
    public function itemFindById($id);
    public function randomItems();

    //Commands
    public function itemCreate($data);
}