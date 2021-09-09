<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

//Models
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function list(Request $request)
    {
        if ($request->has('searchText')) {
            return new PaginationResource( User::where('name', 'LIKE', '%' . $request->searchText . '%')
                ->orWhere('email', 'LIKE', '%' . $request->searchText . '%')
                ->select('name', 'email', 'role_id', 'created_at', 'updated_at')
                ->with('role')
                ->paginate(3));
          } else {
            return new PaginationResource(User::with('role')->paginate(3));
          }

        // $users = new PaginationResource(User::with('role')->paginate(3));
        // return response()->json(['users'=>$users], 200);
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
        User::find($id)->delete();
        $response = [
            'message' => 'Record Deleted Successfully',
        ];
        return response($response, 200);
    }
}
