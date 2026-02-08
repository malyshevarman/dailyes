<?php

namespace App\Http\Controllers\Api\Cabinet\Event\Category;

use App\Category as Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function all()
    {
        return Category::orderBy('name')->get();
    }
}
