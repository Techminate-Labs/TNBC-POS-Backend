<?php

namespace App\Services;

//Interface
use App\Contracts\ProfileRepositoryInterface;

class ProfileServices{
    
    private $repositoryInterface;

    public function __construct(ProfileRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function details($id){
        
    }
    
}