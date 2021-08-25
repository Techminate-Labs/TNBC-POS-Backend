<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json(['users'=>$users], 200);
    }

    public function updateUser(Request $request, $id)
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

    public function deleteUser($id)
    {
        User::find($id)->delete();
        $response = [
            'message' => 'Record Deleted Successfully',
        ];
        return response($response, 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['user'=>$user], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
