<?php

namespace App\Contracts\User;

interface UserRepositoryInterface
{
    public function userSearch($query, $limit);
    public function userList($limit);
    public function userProfileView($id);
    public function userGetById($id);
    public function userFindById($id);
    public function userGetByEmail($email);
    public function userGetByAuth();
    public function userAuthenticated();
    public function userCreate($data);
}