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

    public function list($request){
        if ($request->has('searchText')){
            $users = $this->ri->searchUser($request->searchText);
        }else{
            $users = $this->ri->userList();
        }
        return new PaginationResource($users);
    }

    public function getById($id){
        return $this->ri->getById($id);
    }

    public function destroy($id){
        $user = $this->ri->findUserById($id);
        $user->delete();
    }

    public function update($request, $id){
        $data = $request->all();
        $user = $this->ri->findUserById($id);

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
    
}