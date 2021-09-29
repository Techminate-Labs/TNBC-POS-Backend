<?php

namespace App\Contracts\Item;

interface SupplierRepositoryInterface
{
    public function supplierSearch($query, $limit);
    public function supplierList($limit);
    public function supplierGetById($id);
    public function supplierCreate($data);
}