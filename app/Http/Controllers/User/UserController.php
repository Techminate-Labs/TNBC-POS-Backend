<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\UserServices;

class UserController extends Controller
{
    private $userServices;

    public function __construct(UserServices $userServices){
        $this->services = $userServices;
    }

    public function userList(Request $request)
    {
        try{
            return $this->services->userList($request);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }

    public function userProfileView($id)
    {
        try{
            return $this->services->userProfileView($id);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }

    public function userGetById($id)
    {
        try{
            $user = $this->services->userGetById($id);
            $response = [
                'data' => $user,
            ];
            return response()->json($response,200);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }

    public function userUpdate(Request $request, $id)
    {
        try{
            $user = $this->services->userUpdate($request, $id);
            $response = [
                'data' => $user
            ];
            return response()->json($response,200);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }

    public function userDelete($id)
    {
        try{
            $user = $this->services->userDelete($id);
            $response = [
                'message' => $user,
            ];
            return response()->json($response,200);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }
}
