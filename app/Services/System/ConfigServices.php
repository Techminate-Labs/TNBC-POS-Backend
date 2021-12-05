<?php

namespace App\Services\System;

//Service
use App\Services\BaseServices;

//Utilities
use App\Utilities\FileUtilities;

//Models
use App\Models\Configuration;

class ConfigServices extends BaseServices{
    public static $imagePath = 'images/logo';
    public static $explode_at = "logo/";
    private $configModel = Configuration::class;
    public function config()
    {
        $id = 1;
        $configuration = $this->baseRI->findById($this->configModel, $id);
        return $configuration;
    }

    public function configUpdate($request)
    {
        $id = 1;
        $configuration = $this->config();
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
            $appLogo = 'app_logo';
            $storeLogo = 'store_logo';
            //image upload
            $appLogo = FileUtilities::imageUpload($appLogo, $request, $url, self::$imagePath, self::$explode_at, $exAppLogoPath, true);
            $storeLogo = FileUtilities::imageUpload($storeLogo, $request, $url, self::$imagePath, self::$explode_at, $exStoreLogoPath, true);
            
            $data['app_logo'] = $appLogo;
            $data['store_logo'] = $storeLogo;
            $configuration->update($data);

            return response($configuration,200);
        }else{
            return response(["failed"=>'Configuration not found'],404);
        }
    }

}