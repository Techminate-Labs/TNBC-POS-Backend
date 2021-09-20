<?php

namespace App\Contracts\User;

interface RoleRepositoryInterface
{
    public function roleSearch($query);
    public function roleList();
    public function roleGetById($id);
    public function roleCreate($data);
}