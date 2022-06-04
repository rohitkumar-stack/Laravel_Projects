<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class adminDashboardController extends Controller
{
    
    //
    function adminDashboard()
    {
        return view('adminDashboard\index');
    }
}
