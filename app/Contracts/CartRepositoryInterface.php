<?php

namespace App\Contracts;

interface CartRepositoryInterface
{
    public function createCart($model, $id);
}