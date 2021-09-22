<?php

namespace App\Contracts\Item;

interface SupplierRepositoryInterface
{
    public function supplierSearch($query);
    public function supplierList();
    public function supplierGetById($id);
    public function supplierCreate($data);
}