<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//index page view
 Route::get('dashboard',[StudentController::class,'index']);


 //student page view
 Route::get('students',[StudentController::class,'student']);

//add student page view
 Route::get('addstudent',[StudentController::class,'addstudent']);

// //login page view
// Route::get('login',[StudentController::class,'login']);

// //forgot-password page view
// Route::get('forgot',[StudentController::class,'forgot']);

// //register page view
// Route::get('register',[StudentController::class,'register']);
