<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\User\UserServices;

class UserController extends Controller
{
    private $userServices;

    public function __construct(UserServices $userServices){
        $this->services = $userServices;
    }

    public function userList(Request $request)
    {
        return $this->services->userList($request);
    }

    public function userProfileView(Request $request, $id)
    {
        return $this->services->userProfileView($request, $id);
    }

    public function userGetById(Request $request, $id)
    {
        return $this->services->userGetById($request, $id);
    }

    public function userUpdate(Request $request, $id)
    {
        return $this->services->userUpdate($request, $id);
    }

    public function userDelete(Request $request, $id)
    {
        return $this->services->userDelete($request, $id);
    }
}
