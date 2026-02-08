<?php

namespace App\Http\Controllers\Api\Cabinet\Company\Category;

use App\Category as Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    public function all()
    {
        return Category::orderBy('name')->get();
    }
}
