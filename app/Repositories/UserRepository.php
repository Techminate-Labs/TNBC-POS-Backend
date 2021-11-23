<?php

namespace App\Repositories\User;

//Interface
use App\Contracts\UserRepositoryInterface;

//Format
use App\Format\UserFormat;

//Models
use App\Models\User;

class UserRepository implements UserRepositoryInterface{

    public function __construct(UserFormat $userFormat){
        $this->userFormat = $userFormat;
    }

    public function userSearch($query, $limit){
        return User::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
                ->through(function($user){
                    return $this->userFormat->formatList($user);
                });
    }

    public function userList($limit){
        return User::orderBy('created_at', 'desc')
                ->paginate($limit)
                ->through(function($user){
                    return $this->userFormat->formatList($user);
                });
    }

    public function userProfileView($id){
        $user = User::where('id',$id)
                ->first();
        if($user){
            return $this->userFormat->formatUserProfile($user);
        }else{
            return [] ;
        }
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