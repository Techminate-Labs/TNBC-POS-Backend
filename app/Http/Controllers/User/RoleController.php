<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

//Model
use App\Models\Role;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        return new PaginationResource(Role::paginate(1));
    }

    //single data
    public function details($id)
    {
        return Role::find($id);
    }
   
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'permissions'=>'required',
        ]);
        // dd($request);
        $role = Role::create($request->all());
        $response = [
            'role' => $role
        ];
        return response($response, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'permissions'=>'required',
        ]);
        
        $role = Role::find($id);
        $role->update($request->all());

        return response()->json(['role'=>$role], 200);
    }

   
    public function destroy($id)
    {
        $role = Role::find($id)->delete();
        $response = [
            'message' => 'Record Deleted Successfully',
        ];
        return response($response, 201);
    }
}
