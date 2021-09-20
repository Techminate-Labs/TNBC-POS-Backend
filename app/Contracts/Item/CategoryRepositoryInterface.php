<?php

namespace App\Contracts\Item;

interface CategoryRepositoryInterface
{
    public function categoryCreate($data);
    public function categoryUpdate($data);
    public function categoryGetById($id);
    
}