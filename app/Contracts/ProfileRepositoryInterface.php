<?php

namespace App\Contracts;

interface ProfileRepositoryInterface
{
    public function details($id);
    public function userProfileCreate($data);
    public function userProfileGetById($id);
    public function userProfileFindById($id);
}