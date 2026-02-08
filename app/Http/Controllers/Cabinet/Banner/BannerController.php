<?php

namespace App\Http\Controllers\Cabinet\Banner;

use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cabinet.banner.index');
    }
}
