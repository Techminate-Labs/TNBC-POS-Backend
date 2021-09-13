<?php

namespace App\Format;

class UserFormat{
    public function formatList($user){
        return[
            'user_id' => $user->id,
            'role' => $user->role->name,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at'=>$user->created_at->diffForHumans(),
            'updated_at'=>$user->updated_at->diffForHumans()
        ];
    }

    public function formatUserProfile($user){
        return[
            'user_id' => $user->id,
            'role' => $user->role->name,
            'email' => $user->email,
            'username' => $user->name,
            'first_name' => $user->profile->first_name,
            'last_name' => $user->profile->last_name,
            'mobile' => $user->profile->mobile,
            'present_address' => $user->profile->present_address,
            'permanent_address' => $user->profile->permanent_address,
            'identity_number' => $user->profile->identity_number,
            'city' => $user->profile->city,
            'zip' => $user->profile->zip,
            'image' => $user->profile->image,
            'created_at'=>$user->created_at->diffForHumans(),
            'updated_at'=>$user->updated_at->diffForHumans()
        ];
    }
}