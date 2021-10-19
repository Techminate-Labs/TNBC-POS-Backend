<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;

//Interface
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\Pos\CartRepositoryInterface;

//Models
use App\Models\Cart;

class AuthServices{

    private $repositoryInterface;

    public function __construct(
        UserRepositoryInterface $repositoryInterface,
        CartRepositoryInterface $cartRepositoryInterface
        ){
        $this->ri = $repositoryInterface;
        $this->cartRI = $cartRepositoryInterface;
        $this->cart = Cart::class;
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

    public function login($request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = $this->ri->userGetByEmail($fields['email']);

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Email or Password Did Not Match!'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        //create cart for a user
        $cart = $this->cartRI->getCart($this->cart, $user->id);
        if(!$cart){
            $cart = $this->cartRI->createCart($this->cart, $user->id);
        }
        
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function logout(){
        $this->ri->userAuthenticated()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}