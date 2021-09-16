<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function userSearch($query);
    public function userList();
    public function userProfileView($id);
    public function userGetById($id);
    public function userFindById($id);
    public function userGetByAuth();
    public function userCreate($data);
}