<?php

namespace App\Services\System;
use Illuminate\Support\Facades\Http;
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

    public function usdRate($currency)
    {
        // $currency = 'BDT';
        $req_url = 'https://open.er-api.com/v6/latest/'.$currency;
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if('success' === $response->result) {
                    return $response->rates->USD;
                }
            }
            catch(Exception $e) {
                return [];
            }
        }
    }
    // this method is to get TNBC rate from exchange
    public function tnbcRate()
    {
        $req_url = 'https://tnbcrow.pythonanywhere.com/recent-trades';
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if('success' === $response->result) {
                    //
                }
            }
            catch(Exception $e) {
                return [];
            }
        }
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
            $data['usd_rate'] = $this->usdRate($data['currency']);
            $configuration->update($data);
            return response($configuration,200);
        }else{
            return response(["failed"=>'Configuration not found'],404);
        }
    }

    public function convCur($request)
    {
        $currency = 'BDT';
        $req_url = 'https://open.er-api.com/v6/latest/'.$currency;
        $response_json = file_get_contents($req_url);

        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if('success' === $response->result) {
                    $localPrice = 500;
                    $rateTnbc = 0.02;
                    $priceUsd = $localPrice * $response->rates->USD;
                    $priceTnbc = $priceUsd / $rateTnbc;
                    return [
                        $currency.' to USD'=>$response->rates->USD,
                        'rate TNBC' => $rateTnbc,
                        'price Local' => $localPrice,
                        'price USD' => $priceUsd,
                        'price TNBC' => $priceTnbc
                    ];
                }
            }
            catch(Exception $e) {
                return [];
            }
        }
    }
}