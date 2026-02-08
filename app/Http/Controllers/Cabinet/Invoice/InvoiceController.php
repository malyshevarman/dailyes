<?php

namespace App\Http\Controllers\Cabinet\Invoice;

use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cabinet.invoice.index');
    }
}
