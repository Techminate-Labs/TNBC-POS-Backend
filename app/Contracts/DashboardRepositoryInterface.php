<?php

namespace App\Contracts;

interface DashboardRepositoryInterface
{
    public function countData($table);
    public function countSales($payment_method);

    public function dateViewChart($payment_method);
    public function dayViewChart($payment_method);
    public function monthViewChart($payment_method);
}