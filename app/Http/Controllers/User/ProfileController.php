<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\ProfileServices;

class ProfileController extends Controller
{
    private $profileServices;

    public function __construct(ProfileServices $profileServices){
        $this->service = $profileServices;
    }

    public function userProfileCreate(Request $request)
    {
        $profile = $this->service->userProfileCreate($request);

        $response = [
            'profile' => $profile,
        ];

        return response($response, 200);
    }

    public function userProfileUpdate(Request $request, $id)
    {
        $profile = $this->service->userProfileUpdate($request, $id);

        $response = [
            'profile' => $profile,
        ];

        return response($response, 200);
    }

    public function userProfileDelete($id)
    {
        $profile = $this->service->userProfileDelete($id);

        $response = [
            'profile' => $profile,
        ];

        return response($response, 200);
    }

    public function userProfileGetById($id){
        $profile = $this->service->userProfileGetById($id);

        $response = [
            'profile' => $profile,
        ];

        return response($response, 200);
    }
}
