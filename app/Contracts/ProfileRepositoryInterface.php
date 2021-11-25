<?php

namespace App\Contracts;

interface ProfileRepositoryInterface
{
    public function userProfileCreate($data);
    public function userProfileFindById($id);
}