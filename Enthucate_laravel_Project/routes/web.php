<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
// use App\Http\Controllers\Superadmin\DashboardController;
// use App\Http\Controllers\Superadmin\OrganisationController;
use App\Http\Controllers\VerifyaccountController;
use App\Http\Controllers\PasswordController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessagechatController;
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
//     return view('auth.login');
// });

// Auth::routes();
// chat


Route::get('/load-latest-messages', [MessagechatController::class, 'getLoadLatestMessages']);
Route::post('/send', [MessagechatController::class, 'postSendMessage']);
Route::get('/fetch-old-messages', [MessagechatController::class, 'getOldMessages']);
Route::get('/read-message', [MessagechatController::class, 'ReadMessage']);
// Route::get('/chatusers', [ChatController::class, 'chatusers']);

// login
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout']);
// verify org account
Route::any('/organisation-verify-email/{id}', [VerifyaccountController::class, 'OrganisationVerify']);
Route::any('/save-organisation-password', [VerifyaccountController::class, 'SaveOrganisation']);
Route::any('/new-password/{id}', [VerifyaccountController::class, 'NewPassword']);

// verify User account
Route::any('/user-verify-email/{id}/{role}', [VerifyaccountController::class, 'UserVerify']);
Route::any('/teacher-verify-email/{id}/{role}', [VerifyaccountController::class, 'TeacherVerify']);
Route::any('/student-verify-email/{id}/{role}', [VerifyaccountController::class, 'StudentVerify']);
Route::any('/parent-verify-email/{id}/{role}', [VerifyaccountController::class, 'ParentVerify']);

Route::any('/add-new-child', [VerifyaccountController::class, 'AddNewChild']);
Route::any('/exist-child-form', [VerifyaccountController::class, 'ExistChildForm']);
Route::any('/update-exist-child-form', [VerifyaccountController::class, 'UpdateExistChildForm']);

//login
Route::any('/password-forgot', [PasswordController::class, 'PasswordForgot']);
Route::any('/passwordforgot', [PasswordController::class, 'ForgotPassword']);
Route::any('/otp/{id}', [PasswordController::class, 'OTP']);
Route::any('/resendcode/{id}', [PasswordController::class, 'resendcode']);
Route::any('/varify-otp', [PasswordController::class, 'VarifyOtp']);

// create user account
Route::any('/create-teacher-account', [VerifyaccountController::class, 'CreateTeacherAccount']);
Route::any('/create-parent-account', [VerifyaccountController::class, 'CreateParentAccount']);
// Home
Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
Route::any('/subdivision', [HomeController::class, 'subdivision']);
Route::any('/org-subdivision', [HomeController::class, 'orgsubdivision']);
Route::any('/state', [HomeController::class, 'GetState']);
Route::any('/city', [HomeController::class, 'GetCity']);
Route::any('/school', [HomeController::class, 'GetSchool']);
Route::any('/grade', [HomeController::class, 'GetGread']);
Route::any('/getclass', [HomeController::class, 'GetClass']);
Route::any('/department', [HomeController::class, 'GetDepartment']);
Route::any('/member', [HomeController::class, 'GetMember']);
Route::any('/group', [HomeController::class, 'GetGroup']);
Route::any('/viewdepartementmember', [HomeController::class, 'ViewDepartementMember']);
Route::any('/deletedapartmentid', [HomeController::class, 'deletedapartmentid']);

Route::group(['prefix' => 'superadmin',  'namespace' => 'App\Http\Controllers\Superadmin', 'middleware' => ['role:1']], function(){
	// dashboard
	Route::get('/dashboard', 'DashboardController@index');
	Route::get('/chat', 'MessageController@index');
	Route::get('/chatusers', 'MessageController@chatusers');
	//roles-permission
	Route::any('/roles-permission', 'DashboardController@RolesPermission');
	Route::any('/get-roles-permission-data', 'DashboardController@GetRolesPermissionData');
	Route::any('/update-roles-permission-data', 'DashboardController@UpdateRolesPermissionData');
	// profile
	Route::any('/profile', 'DashboardController@Profile');
	Route::any('/update-profile', 'DashboardController@UpdateProfile');

	// Department
	Route::get('/department-list', 'DepartmentController@index');
	Route::get('/add-department', 'DepartmentController@create');
	Route::post('/save-department', 'DepartmentController@store');
	Route::any('/delete-department', 'DepartmentController@destroy');
	Route::get('/edit-department/{id}', 'DepartmentController@edit');
	Route::any('/update-department/{id}', 'DepartmentController@update');
	Route::any('/departmentlist', 'DepartmentController@DepartmentList');

	// Group
	Route::get('/group-list', 'GroupController@index');
	Route::get('/add-group', 'GroupController@create');
	Route::post('/save-group', 'GroupController@store');
	Route::any('/delete-group', 'GroupController@destroy');
	Route::get('/edit-group/{id}', 'GroupController@edit');
	Route::any('/update-group/{id}', 'GroupController@update');
	Route::any('/grouplist', 'GroupController@GroupList');

	// Message
	Route::get('/message-list', 'MessageController@index');
	Route::get('/add-message', 'MessageController@create');
	Route::post('/save-message', 'MessageController@store');
	Route::any('/delete-message', 'MessageController@destroy');
	Route::get('/edit-message/{id}', 'MessageController@edit');
	Route::any('/update-message/{id}', 'MessageController@update');
	//Route::any('/messagelist', 'MessageController@GroupList');


	// School
	Route::get('/school-list', 'SchoolController@index');
	Route::get('/add-school', 'SchoolController@create');
	Route::post('/save-school', 'SchoolController@store');
	Route::any('/delete-school', 'SchoolController@destroy');
	Route::get('/edit-school/{id}', 'SchoolController@edit');
	Route::any('/update-school/{id}', 'SchoolController@update');
	Route::any('/schoollist', 'SchoolController@SchoolList');

	// Grade
	Route::get('/grade-list', 'GradeController@index');
	Route::get('/add-grade', 'GradeController@create');
	Route::post('/save-grade', 'GradeController@store');
	Route::any('/delete-grade', 'GradeController@destroy');
	Route::get('/edit-grade/{id}', 'GradeController@edit');
	Route::any('/update-grade/{id}', 'GradeController@update');
	Route::any('/gradelist', 'GradeController@GradeList');

	// Class
	Route::get('/class-list', 'ClassesController@index');
	Route::get('/add-class', 'ClassesController@create');
	Route::post('/save-class', 'ClassesController@store');
	Route::any('/delete-class', 'ClassesController@destroy');
	Route::get('/edit-class/{id}', 'ClassesController@edit');
	Route::any('/update-class/{id}', 'ClassesController@update');
	Route::any('/classlist', 'ClassesController@ClassList');

	// Users
	Route::get('/user-list', 'UserController@index');
	Route::get('/add-user', 'UserController@create');
	Route::post('/save-user', 'UserController@store');
	Route::any('/delete-user', 'UserController@destroy');
	Route::get('/edit-user/{id}', 'UserController@edit');
	Route::any('/update-user/{id}', 'UserController@update');
	Route::any('/userlist', 'UserController@UserList');


	// org
	Route::get('/organisation-list', 'OrganisationController@index');
	Route::get('/add-organisation', 'OrganisationController@create');
	Route::post('/save-organisation', 'OrganisationController@store');
	Route::get('/edit-organisation/{id}', 'OrganisationController@edit');
	Route::any('/delete-organisation', 'OrganisationController@destroy');
	Route::any('/update-organisation/{id}', 'OrganisationController@update');


});
// Route::group(['prefix' => '{company_name}/admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['role:2|3|4|5|6|7|8']], function(){
Route::group(['prefix' => '{company_name}/admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['role:2']], function(){
	// dashboard
	Route::get('/', 'DashboardController@index');
	Route::get('/chat', 'MessageController@index');
	Route::get('/chatusers', 'MessageController@chatusers');
	// profile
	Route::any('/profile', 'DashboardController@Profile');
	Route::any('/update-profile', 'DashboardController@UpdateProfile');

	// Department
	Route::get('/department-list', 'DepartmentController@index');
	Route::get('/add-department', 'DepartmentController@create');
	Route::post('/save-department', 'DepartmentController@store');
	Route::any('/delete-department', 'DepartmentController@destroy');
	Route::get('/edit-department/{id}', 'DepartmentController@edit');
	Route::any('/update-department/{id}', 'DepartmentController@update');
	Route::any('/departmentlist', 'DepartmentController@DepartmentList');

	// Group
	Route::get('/group-list', 'GroupController@index');
	Route::get('/add-group', 'GroupController@create');
	Route::post('/save-group', 'GroupController@store');
	Route::any('/delete-group', 'GroupController@destroy');
	Route::get('/edit-group/{id}', 'GroupController@edit');
	Route::any('/update-group/{id}', 'GroupController@update');
	Route::any('/grouplist', 'GroupController@GroupList');

	// Message
	Route::get('/message-list', 'MessageController@index');
	Route::get('/add-message', 'MessageController@create');
	Route::post('/save-message', 'MessageController@store');
	Route::any('/delete-message', 'MessageController@destroy');
	Route::get('/edit-message/{id}', 'MessageController@edit');
	Route::any('/update-message/{id}', 'MessageController@update');
	//Route::any('/messagelist', 'MessageController@GroupList');

	// School
	Route::get('/school-list', 'SchoolController@index');
	Route::get('/add-school', 'SchoolController@create');
	Route::post('/save-school', 'SchoolController@store');
	Route::any('/delete-school', 'SchoolController@destroy');
	Route::get('/edit-school/{id}', 'SchoolController@edit');
	Route::any('/update-school/{id}', 'SchoolController@update');
	Route::any('/schoollist', 'SchoolController@SchoolList');

	// Grade
	Route::get('/grade-list', 'GradeController@index');
	Route::get('/add-grade', 'GradeController@create');
	Route::post('/save-grade', 'GradeController@store');
	Route::any('/delete-grade', 'GradeController@destroy');
	Route::get('/edit-grade/{id}', 'GradeController@edit');
	Route::any('/update-grade/{id}', 'GradeController@update');
	Route::any('/gradelist', 'GradeController@GradeList');

	// Class
	Route::get('/class-list', 'ClassesController@index');
	Route::get('/add-class', 'ClassesController@create');
	Route::post('/save-class', 'ClassesController@store');
	Route::any('/delete-class', 'ClassesController@destroy');
	Route::get('/edit-class/{id}', 'ClassesController@edit');
	Route::any('/update-class/{id}', 'ClassesController@update');
	Route::any('/classlist', 'ClassesController@ClassList');

	// Users
	Route::get('/user-list', 'UserController@index');
	Route::get('/add-user', 'UserController@create');
	Route::post('/save-user', 'UserController@store');
	Route::any('/delete-user', 'UserController@destroy');
	Route::get('/edit-user/{id}', 'UserController@edit');
	Route::any('/update-user/{id}', 'UserController@update');
	Route::any('/userlist', 'UserController@UserList');
	
	// org
	Route::group([ 'middleware' => ['role:2']], function(){
		Route::get('/organisation-list', 'OrganisationController@index');
		Route::get('/add-organisation', 'OrganisationController@create');
		Route::post('/save-organisation', 'OrganisationController@store');
		Route::get('/edit-organisation/{id}', 'OrganisationController@edit');
		Route::any('/delete-organisation', 'OrganisationController@destroy');
		Route::any('/update-organisation/{id}', 'OrganisationController@update');
	});
});
// organisation
// Route::group(['middleware' => 'role_id:1'], function() {
//Route::group(['middleware' => 'role'], function(){
	
//});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
