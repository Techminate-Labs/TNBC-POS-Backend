<?php

namespace App\Repositories\User;

//Interface
use App\Contracts\User\UserRepositoryInterface;

//Format
use App\Format\UserFormat;

//Models
use App\Models\User;

class UserRepository implements UserRepositoryInterface{

    public function __construct(UserFormat $userFormat){
        $this->userFormat = $userFormat;
    }

    public function userSearch($query){
        return User::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'email', 'role_id', 'created_at', 'updated_at')
                ->with('role')
                ->paginate(3)
                ->through(function($user){
                    return $this->userFormat->formatList($user);
                });
    }

    public function userList(){
        return User::orderBy('name')
                ->with('role')
                ->paginate(3)
                ->through(function($user){
                    return $this->userFormat->formatList($user);
                });
    }

    public function userProfileView($id){
        $user = User::where('id',$id)
                ->with('role')
                ->with('profile')
                ->firstOrFail();
        return $this->userFormat->formatUserProfile($user);
    }

    public function userGetById($id){
        $user = User::where('id',$id)->firstOrFail();
        return $this->userFormat->formatList($user);
    }

    public function userGetByEmail($email){
        return User::where('email', $email)->with('role')->first();
    }

    public function userFindById($id){
        return User::find($id);
    }

    public function userGetByAuth(){
        return User::find(auth()->user()->id);
    }

    public function userAuthenticated(){
        return auth()->user();
    }
    
    public function userCreate($data){
        return User::create($data);
    }
}