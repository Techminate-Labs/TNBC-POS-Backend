<?php

namespace App\Services\System;

//Interface
use App\Contracts\User\ProfileRepositoryInterface;

//Utilities
use App\Utilities\FileUtilities;

//Models
use App\Models\Configuration;

class ConfigServices{
    private $fileUtilities;
    public static $imagePath = 'images/logo';
    public static $explode_at = "logo/";

    public function __construct(
        FileUtilities $fileUtilities
    ){
        $this->fileUtilities = $fileUtilities;
    }

    public function config()
    {
        $id = 1;
        $configuration = Configuration::where('id', $id)->first();
        return $configuration;
    }

    public function configUpdate($request)
    {
        $id = 1;
        $configuration = Configuration::where('id', $id)->first();
        if($configuration){
            $fields = $request->validate([
                'app_name'=>'required|string',
                'store_name'=>'required|string',
                'currency'=>'required|string',
                'currency_symble'=>'required|string',
                'tnbc_pk'=>'required|string',
                'tnbc_rate'=>'required|numeric',
                'tax_rate'=>'required|numeric',
            ]);
            $data = $request->all();
            $url  = url('');
            $exAppLogoPath = $configuration->app_logo;
            $exStoreLogoPath = $configuration->store_logo;
            //image upload
            $appLogo = $this->fileUtilities->fileUpload($request, $url, self::$imagePath, self::$explode_at, $exAppLogoPath, true);
            $storeLogo = $this->fileUtilities->fileUpload($request, $url, self::$imagePath, self::$explode_at, $exStoreLogoPath, true);
            
            $data['app_logo'] = $appLogo;
            $data['store_logo'] = $storeLogo;

            // $data['discount'] = $fields['discount'];
            $configuration->update($data);

            return response($configuration,201);
        }else{
            return response(["failed"=>'Configuration not found'],404);
        }
    }

}