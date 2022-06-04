<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    // start-login after open dashborad otherwise not open dashboard
    //checking of login
	public function __construct() {
        $this->middleware('auth');
    }

    // End-login after open dashborad otherwise not open dashboard

    //index page view
    public function index()
    {
    	return view('student.index');
    }

    //student view
    public function student()
    {
    	return view('student.student');
    }

    //add-student view
    public function addstudent()
    {
    	return view ('student.addstudent');
    }

    //login page
    public function login()
    {
      return view('student.login');
    }

    //forgot-password
     public function forgot()
    {
      return view('student.forgot');
    }

    //register page view
    public function register()
    {
    	return view('student.register');
    }
}
