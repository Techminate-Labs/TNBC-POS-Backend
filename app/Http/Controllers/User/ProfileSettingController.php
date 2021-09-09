<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
//Rules
use App\Rules\MatchOldPassword;

//Models
use App\Models\User;
use App\Models\Profile;

class ProfileSettingController extends Controller
{
    public function profilePhotoupdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $profile = $user->profile;

        $imagePath = 'images/profile';
        $url  = url('');

        //image update
        if($request->hasFile('image')){
           
            $this->validate($request,[
                'image'=>'required|mimes:jpeg,jpg,png',
            ]);
            $image = $request->file('image');
            
            $imgName = 'img'.time(). '.' .$image->getClientOriginalExtension();
            File::isDirectory($imagePath) or File::makeDirectory($imagePath, 0777, true, true);
            
            $image->move(public_path(env('REL_PUB_FOLD').$imagePath),$imgName);
            
            $fileLocation = $url. '/' .$imagePath . '/' . $imgName;
            $profileImage = $fileLocation;

            //remove existing image
            $splitImg = explode("profile/",$profile->image);
            $storageImg = $splitImg[1];
            if($storageImg !== "default.jpg"){
                $image_path = public_path(env('REL_PUB_FOLD').$imagePath)."/".$storageImg;  
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }else{
            $profileImage = $profile->image;
        }

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
