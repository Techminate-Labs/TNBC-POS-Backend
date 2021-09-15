<?php

namespace App\Services;

//Interface
use App\Contracts\UserRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class UserServices{
    
    private $repositoryInterface;

    public function __construct(UserRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function userList($request){
        if ($request->has('searchText')){
            $users = $this->ri->userSearch($request->searchText);
        }else{
            $users = $this->ri->userList();
        }
        return new PaginationResource($users);
    }

    public function userProfileView($id){
        $user = $this->ri->userProfileView($id);
        if($user){
            return $user;
        }else{
            return response(["failed"=>'User not found'],404);
        }
    }

    public function userGetById($id){
        $user = $this->ri->userGetById($id);
        if($user){
            return $user;
        }else{
            return response(["failed"=>'User not found'],404);
        }
    }

    public function userUpdate($request, $id){
        $user = $this->ri->userFindById($id);
        if($user){
            $data = $request->all();
            if($user->email==$data['email']){
                $request->validate([
                    'name'=>'required',
                    'email'=>'required|string|email|max:255',
                    'role_id'=>'required'
                ]);
            }
            else{
                $request->validate([
                    'name'=>'required',
                    'email'=>'required|string|email|max:255|unique:users',
                    'role_id'=>'required',
                ]);
            }
            $user->update($data);
            return response($user,201);
        }else{
            return response(["failed"=>'User not found'],404);
        }
    }

    public function userDelete($id){
        $user = $this->ri->userFindById($id);
        if($user){
            $user->delete();
            return response()->json('User Deleted Successfully',200);
        }else{
            return response(["failed"=>'User not found'],404);
        }
    }
}