<?php

namespace App\Contracts;

interface ItemRepositoryInterface
{
    public function checkIfObj($propModel, $query);
    public function filterByProp($model, $propModel, $query, $limit, $prop);
}