<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdministrativeController extends Controller
{
    public function province() {
        $response = Http::get('https://wilayah.id/api/provinces.json');

        return $response->json();
    }


    public function regency(String $provinceCode)
    {
        $response = Http::get('https://wilayah.id/api/regencies/'.$provinceCode.'.json');

        return $response->json();
    }


    public function district(String $regencyCode)
    {
        $response = Http::get('https://wilayah.id/api/districts/'.$regencyCode.'.json');

        return $response->json();
    }

    public function village(String $districtCode)
    {
        $response = Http::get('https://wilayah.id/api/villages/'.$districtCode.'.json');

        return $response->json();
    }
}
