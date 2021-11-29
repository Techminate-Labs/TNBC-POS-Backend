<?php

namespace App\Contracts;

interface DashboardRepositoryInterface
{
    public function dateViewChart($invoiceTable, $prop, $payment_method);
    public function dayViewChart($invoiceTable, $prop, $payment_method);
    public function monthViewChart($invoiceTable, $prop, $payment_method);
}