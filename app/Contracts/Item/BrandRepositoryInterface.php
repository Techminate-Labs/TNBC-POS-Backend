<?php

namespace App\Contracts\Item;

interface BrandRepositoryInterface
{
    public function brandSearch($query);
    public function brandList();
    public function brandGetById($id);
    public function brandCreate($data);
}