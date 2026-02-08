<?php

namespace App\Http\Controllers\Frontend\Company\Category;

use App\City;
use App\Category as Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category = null)
    {
    	// $city = city();
        return view('frontend.company.category.show')
            // ->withCity($city)
            ->withCategory($category->load([
                'addresses'
            ]));
    }

//    public function showView(Request $request, CompanyCategoryPath $companyCategoryPath)
//    {
//        $city = $companyCategoryPath->city;
//        $companyCategory = $companyCategoryPath->companyCategory;
//        $companyCategories = Category::all();
//
//        if (empty($companyCategory)) {
//            $companiesQuery = Company::with(['categories']);
//        } else {
//            $companiesQuery = $companyCategory->companies();
//        }
//
//        if ($request->search) {
//            $companiesQuery->where('name', 'LIKE', '%' . $request->search . '%');
//        }
//
//        $companies = $companiesQuery->orderBy($request->input('orderBy.column') ?? 'id', $request->input('orderBy.direction') ?? 'asc')
//            ->paginate($request->input('pagination.per_page') ?? 20);
//
//        return view('frontend.cities.companies.categories.show')
//            ->withCity($city)
//            ->withCompanyCategory($companyCategory)
//            ->withCompanyCategories($companyCategories)
//            ->withCompanies($companies);
//    }
}
