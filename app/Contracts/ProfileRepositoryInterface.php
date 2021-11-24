<?php

namespace App\Contracts\User;

interface ProfileRepositoryInterface
{
    public function userProfileCreate($data);
    public function userProfileFindById($id);
}