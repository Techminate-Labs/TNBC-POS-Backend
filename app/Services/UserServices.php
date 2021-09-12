<?php

namespace App\Services;

//Interface
use App\Contracts\UserRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class UserServices{
    private $repositoryInterface;

    public function __construct(UserRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function list($request){
        $users = $this->ri->list($request);
        return new PaginationResource($users);
    }
}