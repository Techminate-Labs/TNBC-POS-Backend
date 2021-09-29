<?php

namespace App\Contracts\Item;

interface BrandRepositoryInterface
{
    public function brandSearch($query, $limit);
    public function brandList($limit);
    public function brandGetById($id);
    public function brandCreate($data);
}