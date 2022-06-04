<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController extends Controller
{
    //navbar

    function navbar()
    {
        return view('navbar');
    }

//home
    function home()
    {
        return view('home');
    }

//database
   function product()
    {
        $names = product::all();
        return view('product',['product'=>$names]);
    }
}
