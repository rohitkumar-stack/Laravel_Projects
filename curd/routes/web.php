<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\adminController\adminDashboardController;
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

// Route::get('/', function () {
// return view('welcome');
// });
// Route for amin Dashboard 
Route::get('dashboard',[adminDashboardController::class,'adminDashboard']);



Route::get('/',[indexController::class,'welcome']);

Route::get('index',[indexController::class,'view']);

// route for post operation 
Route::post('/curd_post',[indexController::class,'curd_post']);

// route for post operation 
Route::get('/delete_curd/{id}',[indexController::class,'delete_curd']);

// route for view edit page 
Route::get('/edit_curd/{id}',[indexController::class,'edit_curd']);

// route for update editform 
Route::post('update_curd',[indexController::class,'update_curd']);