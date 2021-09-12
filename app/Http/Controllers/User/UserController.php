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

    public function list(Request $request)
    {
        try{
            return $this->services->list($request);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }

    public function getById($id)
    {
        try{
            $user = $this->services->getById($id);
            $response = [
                'data' => $user,
            ];
            return response()->json($response,200);
        }catch (\Exception $e){
            return response()->json([],500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $user = $this->services->update($request, $id);
            $response = [
                'data' => $user
            ];
            return response()->json($response,200);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }

    public function destroy($id)
    {
        try{
            $this->services->destroy($id);
            $response = [
                'message' => 'Record Deleted Successfully',
            ];
            return response()->json($response,200);
        }catch (\Exception $e){
            return response()->json([],500);
        }
    }
}
