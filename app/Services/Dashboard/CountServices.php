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
        $salesTnbc = $this->dashboardRI->countSales('tnbc');
        $salesFiat = $this->dashboardRI->countSales('fiat');
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