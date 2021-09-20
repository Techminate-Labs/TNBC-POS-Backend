<?php

namespace App\Repositories\User;

//Interface
use App\Contracts\User\RoleRepositoryInterface;

//Models
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface{

    public function roleSearch($query){
        return Role::where('name', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'permissions', 'created_at', 'updated_at')
                ->paginate(4);
    }

    public function roleList(){
        return Role::orderBy('name')->paginate(4);
    }

    public function roleGetById($id){
        return Role::find($id);
    }

    public function roleCreate($data){
        return Role::create($data);
    }
}