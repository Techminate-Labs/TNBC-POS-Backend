<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
  
    public function index(Request $request)
    {
        $roles = Role::all();
        return response()->json(['roles'=>$roles], 200);
    }
   
    public function store(Request $request)
    {
        // dd($request);
        $role = Role::create($request->all());
        $response = [
            'role' => $role
        ];
        return response($response, 201);
    }

    public function update(Request $request, $id)
    {
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

    //single data
    public function show($id)
    {
        return Role::find($id);
    }
    
    public function deleteAll(Request $request){
        Role::whereIn('id', $request->roles)->delete();
        return response()->json(['message', 'Records Deleted Successfully'], 200);
    }
}
