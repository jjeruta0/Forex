<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;

class ExchangeRate extends Controller
{
    function index()
    {
        $codes = json_decode(Http::get('https://v6.exchangerate-api.com/v6/'.env('FOREX_KEY').'/codes'),true);
        $result = $codes['result'];
        $country = $codes['supported_codes'];
            if ($result == 'success'){
                $country = $codes['supported_codes'];
                $rates = json_decode(Http::get('https://v6.exchangerate-api.com/v6/'.env('FOREX_KEY').'/latest/PHP'),true);
                return view('components.dashboard', compact('rates','country'));
            }
        
    }

    function exchange_rate()
    {
        
        try {
            
            $codes = json_decode(Http::get('https://v6.exchangerate-api.com/v6/'.env('FOREX_KEY').'/codes'),true);
            $result = $codes['result'];
            if ($result == 'success'){
                $country = $codes['supported_codes'];
                $rates = json_decode(Http::get('https://v6.exchangerate-api.com/v6/'.env('FOREX_KEY').'/latest/PHP'),true)['conversion_rates'];
                return $rates;
            }  
            
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function getCountryName($code) {
        try{
            $countries = json_decode(Storage::disk('local')->get('country.json'));
            foreach($countries as $country) {
                if($country->country_code == $code) {
                    return $country->country_name;
                }
            }
        }catch(\Throwable $th){
            return $th->getMessage();
        }
   
    }


    function conversion($firstCurrency, $secondCurrency, $value)
    { 
        try {
            $conres = json_decode(Http::get('https://v6.exchangerate-api.com/v6/'.env('FOREX_KEY').'/pair/'. $firstCurrency . '/' . $secondCurrency . '/' . $value),true)['conversion_result'];
            return $conres;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }  

    // function offline()
    // { 
    //     return view('includes.navbar');
    // } 
}
