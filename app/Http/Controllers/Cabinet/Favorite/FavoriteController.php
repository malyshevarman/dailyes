<?php

namespace App\Http\Controllers\Cabinet\Favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)


    {

        return view('cabinet.favorite.index')
            ->withEvents($events = (auth()->user())->favorite_events()->paginate(8) )
            ->withCompanies($companies = (auth()->user())->favorite_companies()->paginate(8));
    }
}
