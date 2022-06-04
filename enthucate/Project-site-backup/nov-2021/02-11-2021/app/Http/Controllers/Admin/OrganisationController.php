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
use App\Models\RolesPermissionMeta;

class OrganisationController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index($userid = ''){
        if(Auth::User()->hierarchy_id == '5'){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
        $userid = Auth::User()->id;
        $organisation_url = Auth::User()->organisation_url;
        $organisation_id = Auth::User()->organisation_id;
        $results = $this->GetOrganisation($userid,$organisation_url);

        return view('admin.organisation.organisation',['results'=>$results]);
    }

    public function create(){        
        if(Auth::User()->hierarchy_id == '5'){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
        $org_adds = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','org_add')->first();
        if(empty($org_adds)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
        if(auth()->user()->hierarchy_id == '1')
        {
            $hierarchy_id = 2;
        }
        // else if(auth()->user()->hierarchy_id == '3')
        // {
        //     $hierarchy_id = 4;
        // }
        else{
           $hierarchy_id = auth()->user()->hierarchy_id; 
        }
        $roletypes = RoleType::where('is_del','0')->get();
        $hierarchys = Hierarchy::where('is_del','0');
        $hierarchys->where('id','>', $hierarchy_id);
        $hierarchys = $hierarchys->get();
        $hierarchyLicense = Hierarchy::where('is_del','0')->get(); 
        $countries = Country::get();

        return view('admin.organisation.addorganisation',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries]);
    }

    public function store(Request $request){
        $city = null;
        $state = null;
        if(isset($request->state)){
            $state = $request->state;
        }
        if(isset($request->city)){
           $city = $request->city; 
        }

        if(isset($request->parent_id) && $request->parent_id !=''){
            $user = User::where('organisation_id',$request->parent_id)->first();
            $parent_id = $user->id;
        }
        else{
            $parent_id = Auth::User()->id;
        }
        $orgs = Organisation::where('id',Auth::User()->organisation_id)->first();
        $organisation_url = Auth::User()->organisation_url;
        $validator = \Validator::make($request->all(), [
            'organisation_name' => 'required',
            'level_name' => 'required',
            'license_type' => 'required',
            'username'=> 'required|unique:users',
            'country_code' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number'=> 'required|numeric|unique:users',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
            //return Redirect::back()->withErrors(['errors'=>$validator->errors()->all()]);
        } else {
            // Start JoinID Code
                $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789'); // and any other characters
                shuffle($seed);
                $JoinID = '';
                foreach (array_rand($seed, 6) as $k) {
                    $JoinID .= $seed[$k];
                }
                $JoinID;
                // End JoinID Code

            $users = new User();
            $users->hierarchy_id = $request->level_name;
            $users->role_id = 2;
            $users->name = $request->name;
            $users->JoinID = $JoinID;
            $users->username = $request->username;
            $users->position_title = $request->position_title;
            $users->mobile_number = $request->mobile_number;
            $users->country_code = $request->country_code;
            $users->whatsapp = $request->whatsapp;
            $users->address = $request->address;
            $users->city = $city;
            $users->state = $state;
            $users->email = $request->email;
            $users->country = $request->country;
            $users->organisation_url = $organisation_url;
            $users->save();
            $userid  = $users->id;

            $organisation = new Organisation();
            $organisation->hierarchy_id = $request->level_name;
            $organisation->license_type = $request->license_type;
            $organisation->userid = $userid;
            $organisation->role_id = 2;
            $organisation->parent_id = $parent_id;
            $organisation->organisation_tree = Auth::User()->hierarchy_id;
            $organisation->organisation_name = $request->organisation_name;            
            $organisation->name = $request->name;
            $organisation->username = $request->username;
            $organisation->position_title = $request->position_title;
            $organisation->mobile_number = $request->mobile_number;
            //$users->country_code = $request->country_code;
            $organisation->whatsapp = $request->whatsapp;
            $organisation->address = $request->address;
            $organisation->city = $city;
            $organisation->state = $state;
            $organisation->country = $request->country;
            $organisation->email = $request->email;
            $organisation->save();

            $user = User::where('id', $userid)->first();
            $user->organisation_id = $organisation->id;
            $user->save();
            DB::table($organisation_url.'.users')->insert([
                                                        'id' => $users->id, 
                                                        'role_id' => $user->role_id,
                                                        'hierarchy_id' => $user->hierarchy_id,
                                                        'organisation_id' => $user->organisation_id,
                                                        'name' => $users->name,
                                                        'username' => $users->username, 
                                                        'position_title' => $users->position_title,
                                                        'email' => $users->email, 
                                                        //'password'=> $users->password,
                                                        'mobile_number' => $users->mobile_number, 
                                                        'country_code' => $users->country_code, 
                                                        'whatsapp' => $users->whatsapp,
                                                        'address' => $users->address,
                                                        'city' => $users->city,
                                                        'JoinID' => $users->JoinID,
                                                        'state' => $users->state,
                                                        'country' => $users->country, 
                                                        'organisation_url'=>$organisation_url,
                                                        'created_at' => date("Y-m-d H:i:s")
                                                        ]);
            DB::table($organisation_url.'.organisation')->insert([
                                                        'id' => $organisation->id, 
                                                        'role_id' => $organisation->role_id,
                                                        'hierarchy_id' => $organisation->hierarchy_id,
                                                        'license_type' => $organisation->license_type,
                                                        'userid' => $organisation->userid,
                                                        'organisation_name' => $organisation->organisation_name,
                                                        'name' => $organisation->name,
                                                        'username' => $organisation->username, 
                                                        'position_title' => $organisation->position_title,
                                                        'email' => $organisation->email, 
                                                        'mobile_number' => $organisation->mobile_number, 
                                                        'whatsapp' => $organisation->whatsapp,
                                                        'address' => $organisation->address,
                                                        'city' => $organisation->city,
                                                        'state' => $organisation->state,
                                                        'country' => $organisation->country, 
                                                        'parent_id' => $organisation->parent_id,
                                                        'organisation_tree'=>$organisation->organisation_tree,
                                                        'created_at' => date("Y-m-d H:i:s")
                                                        ]);
            $decodeuserid = base64_encode($userid);
            $loginurl = '/organisation-verify-email/'.$decodeuserid;
            Mail::send('emails.organisation-verifyemail',['username' => $orgs->organisation_name ,'email'=>$request->email,'loginurl'=>$loginurl], function($message) use ($request) {
              $message->to($request->email);
              $message->subject('Enthucate Verify Your Account - Organisation');
           });
             return redirect($organisation_url.'/admin/organisation-list')->with('success', 'Organisation added successfully and Email has been sent!');
        }
    }
    public function show($id)
    {
    }

    public function edit(Request $request,$organisation_url, $id)
    {
        $org_adds = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','org_edit')->first();
        if(empty($org_adds)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
        
       if(Auth::User()->hierarchy_id == '5'){
             return redirect($organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
        if(auth()->user()->hierarchy_id == '1')
        {
            $hierarchy_id = 2;
        }
        else if(auth()->user()->hierarchy_id == '3')
        {
            $hierarchy_id = 1;
        }
        else{
           $hierarchy_id = auth()->user()->hierarchy_id; 
        }
        $roletypes = RoleType::where('is_del','0')->get();
        $hierarchys = Hierarchy::where('is_del','0');
        $hierarchys->where('id','>', $hierarchy_id);
        $hierarchys = $hierarchys->get();
        // $organisation_url = Auth::User()->organisation_url;
        $organisations = DB::table($organisation_url.'.organisation')->where('id',$id)->first();
        $hierarchyLicense = Hierarchy::where('is_del','0')->get();
         
        $countries = Country::get();
        $states = State::where('country_id',$organisations->country)->get();
        $cities = City::where('state_id',$organisations->state)->get();

        return view('admin.organisation.editorganisation',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'organisations'=>$organisations,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries,'states'=>$states,'cities'=>$cities]);
    }
    public function update(Request $request, $organisation_url, $id)
    {
         $validator = \Validator::make($request->all(), [
            'organisation_name' => 'required',
            //'level_name' => 'required',
            //'license_type' => 'required',
            'username'=> 'required|unique:users,username,' . $id . ',organisation_id',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id . ',organisation_id'],
            'country_code' => 'required',
            'mobile_number'=> 'required|numeric|unique:users,mobile_number,' . $id . ',organisation_id',
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

        $input['organisation_name']=$request->organisation_name;
        // $input['hierarchy_id']=$request->level_name;
        // $input['license_type']=$request->license_type;
        $input['name']=$request->name;
        $input['username']=$request->username;
        $input['position_title']=$request->position_title;
        $input['mobile_number']=$request->mobile_number;
        $input['country_code']=$request->country_code;
        $input['whatsapp']=$request->whatsapp;
        $input['email']=$request->email;
        $input['address']=$request->address;
        $input['country']=$request->country;
        $input['city']=$city;
        $input['state']=$state;

        $organisations = Organisation::where('id',$id)->first();
        
        $organisation = DB::table($organisation_url.'.organisation')->where('id',$id)->update($input);
        $organisation_main = DB::table('organisation')->where('id',$id)->update($input);

        unset($input['organisation_name']);
        $user = DB::table($organisation_url.'.users')->where('id',$organisations->userid)->update($input);
        $user_main = DB::table('users')->where('id',$organisations->userid)->update($input);

        return redirect($organisation_url.'/admin/organisation-list')->with('success', 'Organisation Updated successfully!'); 
    }
    public function destroy(Request $request, $organisation_url)
    {
        $id = $request->organisation_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $organisation = DB::table($organisation_url.'.organisation')->where('id',$id)->update($input);
        $user = DB::table($organisation_url.'.users')->where('organisation_id',$id)->update($input);
        $organisation_main = DB::table('organisation')->where('id',$id)->update($input);
        $user_main = DB::table('users')->where('organisation_id',$id)->update($input);

         return redirect($organisation_url.'/admin/organisation-list')->with('success', 'Organisation Deleted successfully!');
        
    }
}
