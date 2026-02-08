<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('backend.report.index');
    }
}
