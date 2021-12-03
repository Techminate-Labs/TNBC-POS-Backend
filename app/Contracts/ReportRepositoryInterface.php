<?php

namespace App\Contracts;

interface ReportRepositoryInterface
{
   public function reportDay($payment_method, $limit, $year, $month, $day);
   public function reportWeek($payment_method, $limit, $year, $startOfTheWeek, $endOfTheWeek);
   public function reportMonth($payment_method, $limit, $year, $month);
}