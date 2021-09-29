<?php

namespace App\Contracts\Item;

interface UnitRepositoryInterface
{
    public function unitSearch($query, $limit);
    public function unitList($limit);
    public function unitGetById($id);
    public function unitCreate($data);
}