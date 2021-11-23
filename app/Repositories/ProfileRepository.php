<?php

namespace App\Repositories\User;

//Interface
use App\Contracts\ProfileRepositoryInterface;

//Models
use App\Models\Profile;

class ProfileRepository implements ProfileRepositoryInterface{

    public function userProfileCreate($data){
        $profile = Profile::create($data);
        return $profile;
    }

    public function userProfileFindById($id){
        return Profile::find($id);
    }
}