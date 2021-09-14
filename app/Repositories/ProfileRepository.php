<?php

namespace App\Repositories;

//Interface
use App\Contracts\ProfileRepositoryInterface;

//Models
use App\Models\Profile;

class ProfileRepository implements ProfileRepositoryInterface{

    public function details($id){
       //
    }

    public function userProfileCreate($data){
        $profile = Profile::create($data);
        return $profile;
    }

    public function userProfileGetById($id){
        $profile = Profile::where('id',$id)->firstOrFail();
        return $profile;
    }

    public function userProfileFindById($id){
        return Profile::find($id);
    }
}