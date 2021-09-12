<?php

namespace App\Repositories;

//Interface
use App\Contracts\UserRepositoryInterface;

//Models
use App\Models\User;

class UserRepository implements UserRepositoryInterface{

    public function searchUser($query){
        return User::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'email', 'role_id', 'created_at', 'updated_at')
                ->with('role')
                ->paginate(3)
                ->through(function($user){
                    return $user->format();
                });
    }

    public function userList(){
        return User::orderBy('name')
                ->with('role')
                ->paginate(3)
                ->through(function($user){
                    return $user->format();
                });
    }

    public function getById($id){
        return User::where('id',$id)
            ->firstOrFail()
            ->format();
    }

    public function findUserById($id){
        return User::find($id);
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