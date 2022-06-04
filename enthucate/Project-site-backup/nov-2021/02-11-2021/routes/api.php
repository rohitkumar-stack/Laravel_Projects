<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\HomeController;
// use App\Http\Controllers\Superadmin\DashboardController;
// use App\Http\Controllers\Superadmin\OrganisationController;
use App\Http\Controllers\Api\VerifyaccountController;
use App\Http\Controllers\Api\PasswordController;

use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessagechatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('login', [RegisterController::class, 'login']);

// API hit data

Route::any('subdivision', [HomeController::class, 'subdivision']);
Route::any('org-subdivision', [HomeController::class, 'orgsubdivision']);
Route::any('state', [HomeController::class, 'GetState']);
Route::any('city', [HomeController::class, 'GetCity']);
Route::any('school', [HomeController::class, 'GetSchool']); //done
Route::any('grade', [HomeController::class, 'GetGread']); //done
Route::any('getclass', [HomeController::class, 'GetClass']); //done
Route::any('department', [HomeController::class, 'GetDepartment']);
Route::any('member', [HomeController::class, 'GetMember']);
Route::any('group', [HomeController::class, 'GetGroup']);
Route::any('viewdepartementmember', [HomeController::class, 'ViewDepartementMember']);
Route::any('deletedapartmentid', [HomeController::class, 'deletedapartmentid']);

// All type registration

Route::any('add-teacher', [VerifyaccountController::class, 'AddTeacher']);
// create user account
Route::any('create-teacher-account', [VerifyaccountController::class, 'CreateTeacherAccount']);
Route::any('create-parent-account', [VerifyaccountController::class, 'CreateParentAccount']);

// super admin Route
Route::group(['prefix' => 'superadmin',  'namespace' => 'App\Http\Controllers\Api\Superadmin'], function(){
	Route::get('dashboard', 'DashboardController@index');
});

// Admin Route
Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Api\Admin'], function(){
});	
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
