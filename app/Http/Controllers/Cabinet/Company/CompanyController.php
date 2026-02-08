<?php

namespace App\Http\Controllers\Cabinet\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO встроить фильтры
        $query = \Auth::user()->companies();

        // $query->whereIn('active', [0,1]);

        if ($request->text) {
            $query->where('name', 'LIKE', '%' . $request->text . '%');
        }

        $companies = (clone $query)->orderBy($request->input('orderBy.column') ?? 'name', $request->input('orderBy.direction') ?? 'asc')
            ->paginate($request->input('pagination.per_page') ?? 12);

        // TODO категории должны просчитываться на наличии в них активных компаний
        return view('cabinet.company.index')
            ->withCompanies($companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cabinet.company.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('cabinet.company.edit');
    }

    public function stat(Company $company)
    {
        return view('cabinet.company.stat')
            ->withEvent($company->load(['views_weekly']));
    }
}
