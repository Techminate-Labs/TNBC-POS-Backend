<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;

//Repository
use App\Repositories\CartRepository;

//Services
use App\Services\BaseServices;

//Models
use App\Models\Cart;

class AuthServices extends BaseServices{
    private $cartModel = Cart::class;

    public function userCreate($request){
        $fields = $request->validate([
            'role_id'=>'required',
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = $this->baseRI->storeInDB(
            $this->userModel,
            [
                'role_id' => $fields['role_id'],
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password'])
            ]
        );

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
        $user = $this->filterRI->filterBy1PropFirst($this->userModel, $fields['email'], 'email');

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Email or Password Did Not Match!'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        //create cart for a user
        $cart = $this->filterRI->filterBy1PropFirst($this->cartModel, $user->id, 'user_id');
        if(!$cart){
            $cart = CartRepository::createCart($this->cartModel, $user->id);
        }
        
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}