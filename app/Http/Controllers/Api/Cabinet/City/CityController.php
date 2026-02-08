<?php

namespace App\Http\Controllers\Api\Cabinet\City;

use App\City;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function all()
    {
        return City::all();
    }
}
