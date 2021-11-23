<?php

namespace App\Repositories\User;

//Interface
use App\Contracts\RoleRepositoryInterface;

//Format
use App\Format\RoleFormat;

//Models
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface{

    public function __construct(RoleFormat $roleFormat){
        $this->roleFormat = $roleFormat;
    }

    public function roleSearch($query, $limit){
        return Role::where('name', 'LIKE', '%' . $query . '%')
                ->select('id','name', 'permissions', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
                ->through(function($role){
                    return $this->roleFormat->formatRoleList($role);
                });
    }

    public function roleList($limit){
        return Role::orderBy('created_at', 'desc')
                ->paginate($limit)
                ->through(function($role){
                    return $this->roleFormat->formatRoleList($role);
                });
    }

    public function roleGetById($id){
        return Role::find($id);
    }

    public function roleCreate($data){
        return Role::create($data);
    }
}