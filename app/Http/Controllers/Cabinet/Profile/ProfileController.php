<?php

namespace App\Http\Controllers\Cabinet\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Avatar;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


    public function deleteuser ()
    {
        User::find(Auth::user()->id)->delete();
        return redirect('/');
    }



}
