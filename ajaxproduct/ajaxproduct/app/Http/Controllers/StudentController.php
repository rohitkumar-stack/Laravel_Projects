<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    //student view page]

   public function student()
    {
    	return view('student.student');
    }
    


}


