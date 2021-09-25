<?php

namespace App\Contracts\Item;

interface ItemRepositoryInterface
{
    public function checkIfCategory($query);
    public function checkIfSupplier($query);
    public function checkIfBrand($query);
    public function checkIfUnit($query);
    
    public function itemSearchByCategory($query);
    public function itemSearchByBrand($query);
    public function itemSearchByUnit($query);
    public function itemSearchBySupplier($query);
    public function itemSearch($query);
    public function itemList();
    public function itemGetById($id);
    public function itemCreate($data);
}