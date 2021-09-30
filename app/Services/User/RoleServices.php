<?php

namespace App\Services\User;

//Interface
use App\Contracts\User\RoleRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class RoleServices{
    
    private $repositoryInterface;

    public function __construct(RoleRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function roleList($request){
        if ($request->has('q')){
            $roles = $this->ri->roleSearch($request->q, $request->limit);
        }else{
            $roles = $this->ri->roleList($request->limit);
        }
        return new PaginationResource($roles);
    }

    public function roleGetById($id){
        $role = $this->ri->roleGetById($id);
        if($role){
            return $role;
        }else{
            return response(["failed"=>'Role not found'],404);
        }
    }

    public function roleCreate($request){
        $request->validate([
            'name'=>'required',
            'permissions'=>'required'
        ]);
        $data = $request->all();

        $role = $this->ri->roleCreate($data);
        return response($role,201);
    }

    public function roleUpdate($request, $id){
        $request->validate([
            'name'=>'required',
            'permissions'=>'required'
        ]);
        $role = $this->ri->roleGetById($id);
        if($role){
            $data = $request->all();
            $role->update($data);
            return response($role,201);
        }else{
            return response(["failed"=>'Role not found'],404);
        }
    }

    public function roleDelete($id){
        $role = $this->ri->roleGetById($id);
        if($role){
            $role->delete();
            return response(["done"=>'Role Deleted Successfully'],200);
        }else{
            return response(["failed"=>'Role not found'],404);
        }
    }

}