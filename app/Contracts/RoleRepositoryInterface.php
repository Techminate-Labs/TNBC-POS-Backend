<?php

namespace App\Contracts\User;

interface RoleRepositoryInterface
{
    public function roleSearch($query, $limit);
    public function roleList($limit);
    public function roleGetById($id);
    public function roleCreate($data);
}