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
        return $this->ri->userProfileView($id);
    }

    public function userGetById($id){
        return $this->ri->userGetById($id);
    }

    public function userUpdate($request, $id){
        $data = $request->all();
        $user = $this->ri->userFindById($id);

        if($user->email==$data['email']){
            $validated = $request->validate([
                'name'=>'required',
                'email'=>'required|string|email|max:255',
                'role_id'=>'required'
            ]);
        }
        else{
            $validated = $request->validate([
                'name'=>'required',
                'email'=>'required|string|email|max:255|unique:users',
                'role_id'=>'required',
            ]);
        }

        $user->update($data);

        return $user;
    }

    public function userDelete($id){
        $user = $this->ri->userFindById($id);
        if($user){
            $user->delete();
            return response()->json('Record Deleted Successfully',200);
        }else{
            return response()->json('user doesnt exits',500);
        }
    }
}