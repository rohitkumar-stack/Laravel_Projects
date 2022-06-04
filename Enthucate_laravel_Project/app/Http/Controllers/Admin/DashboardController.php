<?php

namespace App\Http\Controllers\Admin;

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
        $organisationid = array();
        $organisation_url = Auth::User()->organisation_url;
        $organisationid[] = Auth::User()->organisation_id;
        $orgcount =  0;
        $userid = Auth::User()->id;
        $results = $this->GetOrganisation($userid,$organisation_url);
        if(isset($results['organisations'])){
            $orgcount = count($results['organisations']);
        }
        $getgrganisationbyid = $this->GetOrganisationById($userid,$organisation_url);
        if(!empty($getgrganisationbyid)){
            $organisation_id = $getgrganisationbyid['organisations'];
        }
        else{
            $organisation_id = array();
        } 
        $organisation_ids = array_merge($organisationid,$organisation_id);

        $school =  DB::table($organisation_url.'.school')->whereIn('organisation_id',$organisation_ids)->where('is_del','0')->count();
        $department =  DB::table($organisation_url.'.department')->whereIn('organisation_id',$organisation_ids)->where('is_del','0')->count();
        $group =  DB::table($organisation_url.'.group')->whereIn('organisation_id',$organisation_ids)->where('is_del','0')->count();
        return view('admin.dashboard.dashboard',['orgcount'=>$orgcount,'school'=>$school,'department'=>$department,'group'=>$group]);
    }
    public function Profile()
    {
        $user = user::where('id',Auth::User()->id)->first();
        $countries = Country::get();
        $states = State::where('country_id',$user->country)->get();
        $cities = City::where('state_id',$user->state)->get();
        return view('admin.dashboard.profile',['user'=>$user,'countries'=>$countries,'states'=>$states,'cities'=>$cities]);
    }
    public function UpdateProfile(Request $request, $organisation_url)
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
        $user = DB::table($organisation_url.'.users')->where('id',$request->id)->update($input);
        return redirect($organisation_url.'/admin/profile')->with('success', 'Profile Updated successfully!'); 
    }
}