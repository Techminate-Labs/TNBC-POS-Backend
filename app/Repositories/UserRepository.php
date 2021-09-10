<?php

namespace App\Repositories;

//Models
use App\Models\User;
use App\Models\Role;

class UserRepository implements UserRepositoryInterface{
    public function list($request){
        if ($request->has('searchText')) {
            return User::where('name', 'LIKE', '%' . $request->searchText . '%')
                ->orWhere('email', 'LIKE', '%' . $request->searchText . '%')
                ->select('id','name', 'email', 'role_id', 'created_at', 'updated_at')
                ->with('role')
                ->paginate(3)
                ->through(function($user){
                    return $user->format();
                });
          } else {
            return User::orderBy('name')
                ->with('role')
                ->paginate(3)
                ->through(function($user){
                    return $user->format();
                });
          }
    }

    public function getById($id){
        return User::where('id',$id)
            ->firstOrFail()
            ->format();
    }

    public function destroy($id)
    {
        User::find($id)->delete();
    }

    // public function list(){
    //     return User::orderBy('name')
    //     ->with('role')
    //     ->paginate(3)
    //     ->through(function($user){
    //         return $this->format($user);
    //     });
    // }

    // protected function format($user){
    //     return[
    //         'user_id' => $user->id,
    //         'name' => $user->name,
    //         'role' => $user->role->name,
    //         'email' => $user->email,
    //         'created_at'=>$user->created_at->diffForHumans(),
    //         'updated_at'=>$user->updated_at->diffForHumans()
    //     ];
    // }
}