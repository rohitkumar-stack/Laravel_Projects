<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dummyAPI extends Controller
{
    //
    function getData()
    {
        return ["name"=>"Anil", "email"=>"anil@gmail.com", "address"=>"Delhi"];
    }


}
