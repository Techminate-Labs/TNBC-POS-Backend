<?php

namespace App\Services\Dashboard;

//Interface
use App\Contracts\DashboardRepositoryInterface;

class CountServices{
    public function __construct(
        DashboardRepositoryInterface $dashboardRepositoryInterface
    ){
        $this->dashboardRI = $dashboardRepositoryInterface;
    }

    public function countTotal()
    {
        $invoiceTable = 'invoices';
        $prop = 'payment_method';
        $query1 = 'tnbc';
        $query2 = 'fiat';

        $salesTnbc = $this->dashboardRI->countDataProp1($invoiceTable, $prop, $query1);
        $salesFiat = $this->dashboardRI->countDataProp1($invoiceTable, $prop, $query2);
        $items = $this->dashboardRI->countData('items');
        $categories = $this->dashboardRI->countData('categories');
        $users = $this->dashboardRI->countData('users');
        $roles = $this->dashboardRI->countData('roles');
        
        return [
            'salesTnbc'=> $salesTnbc,
            'salesFiat'=> $salesFiat,
            'totalItems'=> $items,
            'totalCategories'=> $categories,
            'totalUsers'=> $users,
            'totalRoles'=> $roles,
        ];
    }
}