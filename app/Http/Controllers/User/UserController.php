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
        return $this->services->list($request);
       
    }

    public function getById($id)
    {
        $user =  $this->ri->getById($id);
        $response = [
            'user' => $user,
        ];
        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);

        if($user->email==$data['email']){
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required|string|email|max:255',
                'role_id'=>'required',
            ]);
        }
        else{
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required|string|email|max:255|unique:users',
                'role_id'=>'required',
            ]);
        }

        $user->update($data);

        return response()->json(['user'=>$user], 200);
    }

    public function destroy($id)
    {
        $this->ri->destroy($id);
        $response = [
            'message' => 'Record Deleted Successfully',
        ];
        return response($response, 200);
    }
}
