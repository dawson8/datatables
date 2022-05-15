<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatatableController extends Controller
{
    public function __invoke()
    {
        return view('datatable');
    }
}
