<?php

namespace App\Contracts;

interface CartRepositoryInterface
{
    public static function createCart($model, $id);
}