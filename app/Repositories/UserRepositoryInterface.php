<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function list($request);
    public function getById($id);
    public function destroy($id);
}