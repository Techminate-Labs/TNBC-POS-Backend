<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
//Rules
use App\Rules\MatchOldPassword;

//Utilities
use App\Utilities\FileUtilities;

//Models
use App\Models\User;
use App\Models\Profile;

class ProfileSettingController extends Controller
{
    public function __construct(FileUtilities $fileUtilities){
        $this->fileUtilities = $fileUtilities;
    }

    public function profilePhotoupdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $profile = $user->profile;
        $url  = url('');
        $imagePath = 'images/profile';
        $exImagePath = $profile->image;

        //image update
        $profileImage = $this->fileUtilities->fileUpload($request, $url, $imagePath, $exImagePath, true);

        $profile->image = $profileImage;
        $profile->save();

        $response = [
            'profileImage' => $profileImage,
        ];
        return response($response, 200);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        // auth()->user()->tokens()->delete();
        
        $response = [
            'success' => "Password changed successfully."
        ];
        return response($response, 201);
    }
}
