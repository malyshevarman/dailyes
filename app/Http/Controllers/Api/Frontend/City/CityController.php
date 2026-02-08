<?php

namespace App\Http\Controllers\Api\Frontend\City;

use App\Http\Controllers\Controller;
use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    // ближайший город
    public function near()
    {
        return City::near()->first();
    }

    public function all()
    {
        return City::whereHas('addresses', function ($q) {
            $q->whereHas('company', function ($q) {
                $q->active();
            });
        })->get();
    }

    public function set(Request $request)
    {
    	$result = setcookie ("citySlug", $request->slug,time()+60*60*24*30, "/", ".dailyes.ru");
    	return response()->json($result);
    }
}
