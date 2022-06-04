<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organisation;
use App\Models\RoleType;
use App\Models\Hierarchy;
use Redirect;
use Mail;
use DB;
use Session;
use Config;
use File;
use Auth;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\RolesPermission;
use App\Models\RolesPermissionMeta;
use App\Models\School;
use App\Models\Group;
use App\Models\Department;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orgcount = Organisation::where('is_del','0')->count();
        $school = School::where('is_del','0')->count();
        $group = Group::where('is_del','0')->count();
        $department = Department::where('is_del','0')->count();
        return view('superadmin.dashboard.dashboard',['orgcount'=>$orgcount,'school'=>$school,'department'=>$department,'group'=>$group]);
    }
    public function RolesPermission()
    {
        $roletypes = RoleType::where('is_del','0')->get();
        return view('superadmin.dashboard.roles-permission',['roletypes'=>$roletypes]);
    }
    public function GetRolesPermissionData(Request $request)
    {
        // $department_delete
        // $org_
       $request->id; 
       $result = array();
       $rolepermission = RolesPermission::where('role_id',$request->id)->first();
       if(!empty($rolepermission)){
            $rolepermissionmeta = RolesPermissionMeta::where('role_id',$request->id)->where('permission_id',$rolepermission->id)->get();
            $result=$rolepermissionmeta;
       }
       return $result;
    }
    public function UpdateRolesPermissionData(Request $request)
    {
        $input = $request->all();
        $rolepermission = RolesPermission::where('role_id',$request->role_id)->first();
        if(empty($rolepermission)){
            $rolepermission = new RolesPermission();             
        }
        $rolepermission->role_id = $request->role_id;
        $rolepermission->role = $request->role;
        $rolepermission->save();        
        $notetodomemberu = RolesPermissionMeta::where('role_id', $request->role_id)->where('permission_id', $rolepermission->id)->delete();
        unset($input['role']);
        unset($input['role_id']);
        unset($input['_token']);
        foreach ($input as $key => $value) {
            $rolepermissionmeta = new RolesPermissionMeta();

            $rolepermissionmeta->role_id = $rolepermission->role_id;
            $rolepermissionmeta->permission_id = $rolepermission->id;
            $rolepermissionmeta->meta_key = $key;
            $rolepermissionmeta->meta_value = $value;

            $rolepermissionmeta->save();
        }
    }

    public function Profile()
    {
        $user = user::where('id',Auth::User()->id)->first();
        $countries = Country::get();
        $states = State::where('country_id',$user->country)->get();
        $cities = City::where('state_id',$user->state)->get();
        return view('superadmin.dashboard.profile',['user'=>$user,'countries'=>$countries,'states'=>$states,'cities'=>$cities]);
    }
    public function UpdateProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username'=> 'required|unique:users,username,' . $request->id . ',id',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id . ',id'],
            'country_code' => 'required',
            'mobile_number'=> 'required|numeric|unique:users,mobile_number,' . $request->id . ',id',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $city = null;
        $state = null;
        if(isset($request->state)){
            $state = $request->state;
        }
        if(isset($request->city)){
           $city = $request->city; 
        }
        $users = User::find($request->id);
        if ($request->hasfile('profile_pic'))
        {
           $characters = substr($_FILES["profile_pic"]["name"], strrpos($_FILES["profile_pic"]["name"], '.' )+1);
            $newFileName = date('mdYHis') . '-avatar-enthucate.' . $characters;
            $fileTmpPath = $_FILES["profile_pic"]["tmp_name"];

            $uploadFileDir = base_path() . '/images/user_profile/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path))
            {
                $input['profile_pic']=$newFileName;
            }
        }

        $input['name']=$request->name;
        $input['username']=$request->username;
        $input['mobile_number']=$request->mobile_number;
        $input['whatsapp']=$request->whatsapp;
        $input['email']=$request->email;
        $input['address']=$request->address;
        $input['country']=$request->country;
        $input['city']=$city;
        $input['state']=$state;
        $input['country_code']=$request->country_code;
        $organisation_main = User::where('id',$request->id)->update($input);
        return redirect('/superadmin/profile')->with('success', 'Profile Updated successfully!'); 
    }
    
}