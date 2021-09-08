<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PaginationResource;

use App\Models\User;
use App\Models\Profile;
use App\Models\Role;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('searchText')) {
            return new PaginationResource( User::where('name', 'LIKE', '%' . $request->searchText . '%')
                ->orWhere('email', 'LIKE', '%' . $request->searchText . '%')
                ->select('name', 'email', 'role_id', 'created_at', 'updated_at')
                ->with('role')
                ->paginate(3));
          } else {
            return new PaginationResource(User::with('role')->paginate(3));
          }

        // $users = new PaginationResource(User::with('role')->paginate(3));
        // return response()->json(['users'=>$users], 200);
    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);

        if($user->email==$data['email']){
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required|string|email|max:255',
                'role_id'=>'required',
            ]);
        }
        else{
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required|string|email|max:255|unique:users',
                'role_id'=>'required',
            ]);
        }

        $user->update($data);

        return response()->json(['user'=>$user], 200);
    }

    public function deleteUser($id)
    {
        User::find($id)->delete();
        $response = [
            'message' => 'Record Deleted Successfully',
        ];
        return response($response, 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        $role = Role::where('id',$user->role_id)->get();
        // $rolename = $role->name;
        $rolename = $user->role->name;
        $profile = Profile::where('user_id',$user->id)->get();

        $response = [
            'user' => $user,
            'rolename' => $rolename,
            'profile'=>$profile
        ];

        return response($response, 200);

        // $user = User::where('id',$id)->with('role')->with('profile')->first();
        // return response()->json(['user'=>$user], 200);
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
            'profile' => $profileImage,
        ];

        return response($response, 200);
    }
}
