<?php

namespace App\Services;

//Interface
use App\Contracts\ProfileRepositoryInterface;

//Utilities
use App\Utilities\FileUtilities;

class ProfileServices{
    
    private $repositoryInterface;
    private $fileUtilities;
    public static $imagePath = 'images/profile';
    public static $explode_at = "profile/";

    public function __construct(ProfileRepositoryInterface $repositoryInterface, FileUtilities $fileUtilities){
        $this->ri = $repositoryInterface;
        $this->fileUtilities = $fileUtilities;
    }

    public function userProfileCreate($request){
        $request->validate([
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

        $profile = $this->ri->userProfileCreate($data);
        return $profile;
    }

    public function userProfileUpdate($request, $id){
        $request->validate([
            'mobile'=>'required',
            'present_address'=>'required|min:3',
            'identity_number'=>'required|numeric',
            'user_id'=>'required',
        ]);
        $profile = $this->ri->userProfileFindById($id);
        if($profile){
            $data = $request->all();
            $exImagePath = $profile->image;
            $url  = url('');
            
            //image upload
            $profileImage = $this->fileUtilities->fileUpload($request, $url, self::$imagePath, self::$explode_at, $exImagePath, true);
            $data['image'] = $profileImage;

            $profile->update($data);
            return $profile;
        }else{
            return response('Profile not found');
        }
    }

    public function userProfileDelete($id){
        $profile = $this->ri->userProfileFindById($id);
        if($profile){
            $exImagePath = $profile->image;
            $this->fileUtilities->removeExistingFile(self::$imagePath, $exImagePath, self::$explode_at);
            $profile->delete();
            return response('Profile Deleted Successfully');
        }else{
            return response('Profile not found');
        }
    }

    public function userProfileGetById($id){
        $profile = $this->ri->userProfileFindById($id);
        if($profile){
            return $profile;
        }else{
            return response('Profile not found');
        }
    }
    
}