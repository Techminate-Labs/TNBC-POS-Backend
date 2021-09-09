<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

//Models
use App\Models\User;
use App\Models\Profile;
use App\Models\Role;

class ProfileController extends Controller
{
    public function details($id)
    {
        $user = User::where('id',$id)->with('role')->with('profile')->first();
        $response = [
            'user' => $user,
        ];
        return response($response, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'mobile'=>'required',
            'present_address'=>'required|min:3',
            'image'=>'required|mimes:jpeg,png,jpg',
            'identity_number'=>'required|numeric',
            'user_id'=>'required',
        ]);
         // dd($request);
        $data = $request->all();

        $imagePath = 'images/profile';
        $url  = url('');

        //image update
        if($request->hasFile('image')){
            $image = $request->file('image');
            
            $imgName = 'img'.time(). '.' .$image->getClientOriginalExtension();
            File::isDirectory($imagePath) or File::makeDirectory($imagePath, 0777, true, true);

            $image->move(public_path(env('REL_PUB_FOLD').$imagePath),$imgName);
            
            // $image->move(public_path($imagePath),$imgName);
            // $image->move('./images/profile/',$imgName);
            // $image->move(public_path().'/images/profile/',$imgName);

            // $fileLocation = $url.  '/'. 'storage/' .$imagePath . '/' . $imgName;
            // $data['image'] = $fileLocation;
            // $image->storeAs('public/'.$imagePath, $imgName);
            // $image->move(storage_path('app/document'),$imgName);
            
            $fileLocation = $url. '/' .$imagePath . '/' . $imgName;
            $data['image'] = $fileLocation;
        }else{
            $data['image'] = $url. '/' .$imagePath . '/' . 'default.jpg';
            // $data['image'] = $url.  '/'. 'storage/' .$imagePath . '/' . 'default.jpg';
        }

        Profile ::create($data);

        $response = [
            'profile' => $data,
        ];

        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'mobile'=>'required',
            'present_address'=>'required|min:3',
            'identity_number'=>'required|numeric',
            'user_id'=>'required',
        ]);

        $profile = Profile::find($id);
        $data = $request->all();

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
            $data['image'] = $fileLocation;

            // $str = "http://127.0.0.1:8000/images/profile/img1630067109.jpg";
            // $serverImg=explode("profile/",$str);
            // print_r ($serverImg[1]);

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
            $data['image'] = $profile->image;
        }

        $profile->update($data);

        $response = [
            'profile' => $data,
        ];

        return response($response, 200);
    }

    public function destroy($id)
    {
        $profile = Profile::find($id);
        $splitImg = explode("profile/",$profile->image);
        $storageImg = $splitImg[1];
        if($storageImg !== "default.jpg"){
            $imagePath = 'images/profile';
            $image_path = public_path(env('REL_PUB_FOLD').$imagePath)."/".$storageImg;  
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        $profile->delete();
        // \Storage::delete($image_path); 

        $response = [
            'profile' => "User Profile Deleted Successfully.",
        ];

        return response($response, 200);
    }
}
