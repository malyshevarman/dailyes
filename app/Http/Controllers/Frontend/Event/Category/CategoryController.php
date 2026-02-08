<?php

namespace App\Http\Controllers\Frontend\Event\Category;

use App\City;
use App\Category as Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category = null)
    {
    	// $city = city();
    	
        return view('frontend.event.category.show')
            // ->withCity($city)
            ->withCategory($category);
    }
}
