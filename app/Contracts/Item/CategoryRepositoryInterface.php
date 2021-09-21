<?php

namespace App\Contracts\Item;

interface CategoryRepositoryInterface
{
    public function categorySearch($query);
    public function categoryList();
    public function categoryGetById($id);
    public function categoryCreate($data);
}