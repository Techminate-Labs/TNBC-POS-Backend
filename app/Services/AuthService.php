<?php

namespace App\Services;

//Interface
use App\Contracts\UserRepositoryInterface;

//Resources
use App\Http\Resources\PaginationResource;

class AuthServices{

    private $repositoryInterface;

    public function __construct(UserRepositoryInterface $repositoryInterface){
        $this->ri = $repositoryInterface;
    }

    public function userCreate($request){
        $fields = $request->validate([
            'role_id'=>'required',
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = $this->ri->userCreate([
            'role_id' => $fields['role_id'],
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

}