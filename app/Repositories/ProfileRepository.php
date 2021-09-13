<?php

namespace App\Repositories;

//Interface
use App\Contracts\ProfileRepositoryInterface;

//Models
use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface{

    public function details($id){
        $user = User::where('id',$id)->with('role')->with('profile')->first();
        return $user;
    }
}