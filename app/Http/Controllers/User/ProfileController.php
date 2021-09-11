<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

//Utilities
use App\Utilities\FileUtilities;

//Models
use App\Models\User;
use App\Models\Profile;
use App\Models\Role;

class ProfileController extends Controller
{
    private $fileUtilities;
    public static $imagePath = 'images/profile';
    public static $explode_at = "profile/";

    public function __construct(FileUtilities $fileUtilities){
        $this->fileUtilities = $fileUtilities;
    }

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
            'identity_number'=>'required|numeric',
            'user_id'=>'required',
        ]);
        $data = $request->all();
        $url  = url('');
        
        //image upload
        $profileImage = $this->fileUtilities->fileUpload($request, $url, self::$imagePath, self::$explode_at, false, false);
        $data['image'] = $profileImage;

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
        $url  = url('');
        $exImagePath = $profile->image;

        //image update
        $profileImage = $this->fileUtilities->fileUpload($request, $url, self::$imagePath, self::$explode_at, $exImagePath, true);
        $data['image'] = $profileImage;
        $profile->update($data);

        $response = [
            'profile' => $data,
        ];

        return response($response, 200);
    }

    public function destroy($id)
    {
        $profile = Profile::find($id);
        $exImagePath = $profile->image;
        $this->fileUtilities->removeExistingFile(self::$imagePath, $exImagePath, self::$explode_at);
        $profile->delete();

        $response = [
            'profile' => "User Profile Deleted Successfully.",
        ];

        return response($response, 200);
    }
}
