<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function searchUser($query);
    public function userList();
    public function getById($id);
    public function findUserById($id);
}