<?php

namespace App\Contracts\Item;

interface UnitRepositoryInterface
{
    public function unitSearch($query);
    public function unitList();
    public function unitGetById($id);
    public function unitCreate($data);
}