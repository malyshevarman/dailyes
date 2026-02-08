<?php

namespace App\Http\Controllers\Backend\Company\Address;

use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company.address.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('backend.company.address.edit');
    }
}
