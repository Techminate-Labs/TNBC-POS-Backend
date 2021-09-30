<?php

namespace App\Contracts\Item;

interface ItemRepositoryInterface
{
    //Query
    public function checkIfCategory($query);
    public function checkIfSupplier($query);
    public function checkIfBrand($query);
    public function checkIfUnit($query);
    
    public function itemSearchByCategory($query, $limit);
    public function itemSearchByBrand($query, $limit);
    public function itemSearchByUnit($query, $limit);
    public function itemSearchBySupplier($query, $limit);
    public function itemSearch($query, $limit);
    public function itemList($limit);

    public function itemGetById($id);
    public function itemFindById($id);

    //Commands
    public function itemCreate($data);
}