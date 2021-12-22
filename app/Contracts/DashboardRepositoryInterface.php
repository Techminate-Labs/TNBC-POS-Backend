<?php

namespace App\Contracts;

interface DashboardRepositoryInterface
{
    public function countData($table);
    public function countSales($payment_method);

    public function currentMonthSalesChart($payment_method);
    public function currentWeekSalesChart($payment_method);
    public function currentYearSalesChart($payment_method);
}