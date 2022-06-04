<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //index

    public function index()
    {
        return view('Employee.index');
    }

    public function jqueryValidation()
    {
        return view('Employee.jqueryValidation');
    }
}
