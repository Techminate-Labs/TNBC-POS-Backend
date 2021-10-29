<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\Pos\CartRepositoryInterface;

//Models
use App\Models\Cart;
use App\Models\User;

class AuthServices{
    private $baseRepositoryInterface;
    private $filterRepositoryInterface;
    private $userRepositoryInterface;
    private $cartRepositoryInterface;

    public function __construct(
        BaseRepositoryInterface $baseRepositoryInterface,
        FilterRepositoryInterface $filterRepositoryInterface,
        UserRepositoryInterface $userRepositoryInterface,
        CartRepositoryInterface $cartRepositoryInterface
        ){
        $this->baseRI = $baseRepositoryInterface;
        $this->filterRI = $filterRepositoryInterface;
        $this->userRI = $userRepositoryInterface;
        $this->cartRI = $cartRepositoryInterface;
        
        $this->cartModel = Cart::class;
        $this->userModel = User::class;
    }

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
        $user = $this->userRI->userGetByEmail($fields['email']);

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
            $cart = $this->cartRI->createCart($this->cartModel, $user->id);
        }
        
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function logout(){
        $this->userRI->userAuthenticated()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}