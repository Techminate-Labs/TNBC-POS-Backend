<?php

namespace App\Contracts\Item;

interface ItemRepositoryInterface
{
    public function itemSearch($query);
    public function itemList();
    public function itemGetById($id);
    public function itemCreate($data);
}