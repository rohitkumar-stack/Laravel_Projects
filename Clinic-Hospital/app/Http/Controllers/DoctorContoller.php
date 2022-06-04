<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorContoller extends Controller
{
    
    //Doctor page view
    public function doctor()
    {
        return view('hospital.doctor');
    }

      //login page view
      public function login()
      {
          return view('hospital.login');
      }
      

}
