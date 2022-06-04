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
use App\Models\School;
use App\Models\UserMeta;
use App\Models\Department;
use App\Models\RolesPermissionMeta;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $organisationid = array();
        $organisation_url = Auth::User()->organisation_url;
        $organisationid[] = Auth::User()->organisation_id;
        $userid = Auth::User()->id;
        $getgrganisationbyid = $this->GetOrganisationById($userid,$organisation_url);
        if(!empty($getgrganisationbyid)){
            $organisation_id = $getgrganisationbyid['organisations'];
        }
        else{
            $organisation_id = array();
        } 
        $organisation_ids = array_merge($organisationid,$organisation_id);
        $results = DB::table($organisation_url.'.users')->where('is_del','0')->where('user_type','=','user')->whereIn('organisation_id',$organisation_ids)->get();
        // $results = User::where('is_del','0')->where('school_id','!=','')->whereIn('organisation_id',$organisation_ids)->get();
        return view('admin.user.user',['results'=>$results]);
    }
    public function UserList(Request $request)
    {
        $organisationid = array();
        $organisation_url = Auth::User()->organisation_url;
        $organisationid[] = Auth::User()->organisation_id;
        $userid = Auth::User()->id;
        $getgrganisationbyid = $this->GetOrganisationById($userid,$organisation_url);
        if(!empty($getgrganisationbyid)){
            $organisation_id = $getgrganisationbyid['organisations'];
        }
        else{
            $organisation_id = array();
        } 
        $organisation_ids = array_merge($organisationid,$organisation_id);

        $start = $_REQUEST['start'];
        $limit = $_REQUEST['length'];
        $search = $_REQUEST['search']['value'];
        $order_count = DB::table($organisation_url.'.users')->where('is_del','0')->where('user_type','=','user')->whereIn('organisation_id',$organisation_ids);
        if($_REQUEST['organisation'] != ''){           
          $order_count->where('organisation_id',$_REQUEST['organisation']);
          
        }
        if($search != ''){
        $order_count->where(function($query) use ($search){
          $query->where('name', 'LIKE', '%' . $search . '%');
          $query->orWhere('email', 'LIKE', '%' . $search . '%');
        });
      }
      $order_count = $order_count->count();
        $result= DB::table($organisation_url.'.users')->where('is_del','0')->where('user_type','=','user')->whereIn('organisation_id',$organisation_ids);
        if($_REQUEST['organisation'] != ''){
          $result->where('organisation_id',$_REQUEST['organisation']);
        }
         if($search != ''){
        $result->where(function($query) use ($search){
          $query->where('name', 'LIKE', '%' . $search . '%');
          $query->orWhere('email', 'LIKE', '%' . $search . '%');
        });
      }
        $result->orderBy('id','DESC')->offset($_REQUEST['start'])->limit($_REQUEST['length']);
        $result = $result->get();
        $client_data = array();
        $order_key = $start;

        $user_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','user_delete')->first();
        $user_edit = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','user_edit')->first();

        foreach ($result as $key => $order) {
          $order_key++;
          
            $organisation = Organisation::where('id', $order->organisation_id)->first();
            $school = School::where('id', $order->school_id)->first();
            $roletype = RoleType::where('id', $order->role_id)->first();
       
            if($order->status == 1){
               $colors = "color: #15a367"; 
               $status = 'Registered';
               $checktype = '<a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>';
            }
            else{
               $colors = "color: #ff6746"; 
               $status = 'Not Registered';
               $checktype = '<a href="#" class="btn btn-dark shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>';
            }

          $action = '';
          $action .= '<div class="d-flex">';
          if(isset($user_edit->meta_value) && $user_edit->meta_value == 'on'){
            $action .= '<a href="'.url(Auth::User()->organisation_url.'/admin/edit-user/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>';
          }
          if(isset($user_add->meta_value) && $user_add->meta_value == 'on'){
            $action .= '<a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markuserdelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteuser" title="Delete user" data-placement="right" ><i class="fa fa-trash"></i></a>
            ';
          }
          $action .= '</div>';
           
            
            

          $client_data[] = array(
           // 'orderno'=>"#$order_key",
            'name'=>$order->name,
            'role'=>$roletype->role,
            'status'=>$status,
            'email'=>$order->email,
            'action'=>$action,
          );
        }
        echo json_encode(array(
          "data"=>$client_data,
          "recordsTotal" => intval($order_count),
          "recordsFiltered" => intval($order_count),
          "draw" => intval(isset($_REQUEST['draw']) ? $_REQUEST['draw'] : 0) ,
        ));die();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','user_add')->first();
        if(empty($user_add)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }

        $roletypes = RoleType::where('is_del','0')->get();
        $hierarchys = Hierarchy::where('is_del','0');        
        $hierarchys = $hierarchys->get();
        $hierarchyLicense = Hierarchy::where('is_del','0')->get(); 
        $countries = Country::get();
        $organisations = Organisation::where('is_del','0')->get(); 
        $organisation_id = Auth::User()->organisation_id;
        $schools = School::where('organisation_id',$organisation_id)->get();
        $departments = Department::where('organisation_id',$organisation_id)->get();

        return view('admin.user.adduser',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries,'organisations'=>$organisations,'schools'=>$schools,'departments'=>$departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'country_code' => 'required',            
            //'username'=> 'required|unique:users',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number'=> 'required|numeric|unique:users',
            'organisation' => 'required',
            // 'school' => 'required',
            'role' => 'required',      
        ]);
        
         if($request->role != 2 && $request->role != 6 && $request->role != 8){
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'country_code' => 'required',            
                //'username'=> 'required|unique:users',
                // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile_number'=> 'required|numeric|unique:users',
                'organisation' => 'required',
                'school' => 'required',
                'role' => 'required',      
            ]);
        }
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
    //     $TWILIO_SID= Config::get('app.TWILIO_SID');
    //     $TWILIO_TOKEN=Config::get('app.TWILIO_TOKEN');
    //     $FROM_NUMBER=Config::get('app.FROM_NUMBER');

    //        $message = 'Hi, Rohit Invites you to signup with.';
    //                   $id = $TWILIO_SID;
    //                   $token = $TWILIO_TOKEN;
    //                   $url = "https://api.twilio.com/2010-04-01/Accounts/".$id."/SMS/Messages";
    //                   $from = $FROM_NUMBER;

    //                     $clientphonenumber = $request->mobile_number;
    //                     $data = array (
    //                     'From' => $from,
    //                     'To' => $clientphonenumber,
    //                     'Body' => $message,
    //                     );
    //                     $post = http_build_query($data);
    //                     $x = curl_init($url );
    //                     curl_setopt($x, CURLOPT_POST, true);
    //                     curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
    //                     curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
    //                     curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //                     curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
    //                     curl_setopt($x, CURLOPT_POSTFIELDS, $post);
    //                     $y = curl_exec($x);
    //                     curl_close($x);
    //                     $array = json_decode(json_encode(simplexml_load_string($y)),1);
    //                     echo '<pre>';
    //                     print_r($array);
    // die('hlo');

        // Start JoinID Code
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789'); // and any other characters
        shuffle($seed);
        $JoinID = '';
        foreach (array_rand($seed, 6) as $k) {
            $JoinID .= $seed[$k];
        }
        $JoinID;
        // End JoinID Code
        // Create Password
        $password = $this->AutoPassword(8);

        $school_id = '';
        if(!empty($request->school)){
           $school_id = implode(",",$request->school); 
        }
        
        $organisation_url = '';
        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        //$input['department_id']=$request->department;
        //$input['username']=$request->username;
        $input['name']=$request->name;
        $input['JoinID']=$JoinID;
        $input['password'] = bcrypt($password);
        $input['mobile_number']=$request->mobile_number;
        $input['country_code']=$request->country_code;
        $input['whatsapp']=$request->whatsapp;
        $input['school_id']=$school_id;
        $input['email']=$request->email;
        $input['role_id']=$request->role;
        $input['position_title']=$request->position_title; 
        $input['organisation_url']=$organisation_url;  
        $input['user_type']='user';      
        //$input['created_by']=Auth::User()->id;

        $school_main = User::insert($input);
        $id = DB::getPdo()->lastInsertId();
        $input['id']=$id;        
        $school = DB::table($organisation_url.'.users')->insert($input);
        unset($input['role_id']);
        unset($input['_token']);

        foreach ($input as $key => $value) {

            $input_data['role_id']= $request->role;
            $input_data['user_id']= $id;
            $input_data['meta_key']= $key;
            $input_data['meta_value']= $value;

            $user_meta_main = UserMeta::insert($input_data);
            $user_meta = DB::table($organisation_url.'.user_meta')->insert($input_data);
        }
        $decodeuserid = base64_encode($id);
        $decoderoleid = base64_encode($request->role);
        if($request->role == 9){
            // $input_data['userid']=$org->id; 
            // $input_data['organisation_id']=$request->organisation; 
            // $input_data['mobile_number']=$request->mobile_number; 
            // $input_data['created_by']=Auth::User()->id; 
            // $school_main = Teachers::insert($input_data);
            // $id = DB::getPdo()->lastInsertId();
            // $input_data['id']=$id;        
            // $school = DB::table($organisation_url.'.teachers')->insert($input_data);

           $loginurl = '/teacher-verify-email/'.$decodeuserid.'/'.$decoderoleid; 
        }elseif($request->role == 10){
           $loginurl = '/student-verify-email/'.$decodeuserid.'/'.$decoderoleid; 
        }elseif($request->role == 11){
           $loginurl = '/parent-verify-email/'.$decodeuserid.'/'.$decoderoleid; 
        }else{
            $loginurl = '/user-verify-email/'.$decodeuserid.'/'.$decoderoleid;
        }

        Mail::send('emails.organisation-verifyemail',['username' => Auth::User()->username,'email'=>$request->email,'loginurl'=>$loginurl], function($message) use ($request) {
          $message->to($request->email);
          $message->subject('Enthucate Verify Your Account - Organisation');
       });

        return redirect($organisation_url.'/admin/user-list')->with('success', 'User added successfully!'); 
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$organisation_url, $id)
    {
        $user_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','user_edit')->first();
        if(empty($user_add)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }

        $user = User::where('id',$id)->first();
        $schools = School::where('organisation_id',$user->organisation_id)->get();
        $roletypes = RoleType::where('is_del','0')->get();
        $departments = Department::where('organisation_id',$user->organisation_id)->get();
        $countries = Country::get();
        return view('admin.user.edituser',['user'=>$user,'schools'=>$schools,'roletypes'=>$roletypes,'departments'=>$departments,'countries'=>$countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$organisation_url, $id)
    {
       
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'country_code' => 'required',
            //'username'=> 'required|unique:users,username,' . $id . ',id',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id . ',id'],
            'mobile_number'=> 'required|numeric|unique:users,mobile_number,' . $id . ',id',
            //'organisation' => 'required',
            // 'school' => 'required',
            'role' => 'required',      
        ]);
        if($request->role != 2 && $request->role != 6 && $request->role != 8){
          $validator = \Validator::make($request->all(), [ 
            'name' => 'required',
            'country_code' => 'required',
            //'username'=> 'required|unique:users,username,' . $id . ',id',
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id . ',id'],
            'mobile_number'=> 'required|numeric|unique:users,mobile_number,' . $id . ',id',
            //'organisation' => 'required',
            'school' => 'required',
            'role' => 'required',
          ]);
        }
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $school_id = '';
        if(!empty($request->school)){
           $school_id = implode(",",$request->school); 
        }

        $organisation_url = '';
        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        //$input['department_id']=$request->department;
        //$input['username']=$request->username;
        $input['name']=$request->name;
        $input['mobile_number']=$request->mobile_number;
        $input['country_code']=$request->country_code;
        $input['whatsapp']=$request->whatsapp;
        $input['school_id']=$school_id;
        $input['email']=$request->email;
        $input['role_id']=$request->role;
        $input['position_title']=$request->position_title; 
        $input['organisation_url']=$organisation_url; 
        $input['user_type']='user';  

        $school_main = User::where('id',$id)->update($input);                
        $school = DB::table($organisation_url.'.users')->where('id',$id)->update($input);

        unset($input['role_id']);
        unset($input['_token']);
        // $notetodomemberu = UserMeta::where('role_id', $request->role)->where('user_id', $id)->delete();
        // $usermeta = DB::table($organisation_url.'.user_meta')->where('role_id', $request->role)->where('user_id', $id)->delete();
        // $input['id']=$id;
        // foreach ($input as $key => $value) {

        //     $input_data['role_id']= $request->role;
        //     $input_data['user_id']= $id;
        //     $input_data['meta_key']= $key;
        //     $input_data['meta_value']= $value;

        //     $user_meta_main = UserMeta::insert($input_data);
        //     $user_meta = DB::table($organisation_url.'.user_meta')->insert($input_data);
        // }

        // $decodeuserid = base64_encode($id);
        // $decoderoleid = base64_encode($request->role);
        // if($request->role == 9){
        //    $loginurl = '/teacher-verify-email/'.$decodeuserid.'/'.$decoderoleid; 
        // }elseif($request->role == 10){
        //    $loginurl = '/student-verify-email/'.$decodeuserid.'/'.$decoderoleid; 
        // }elseif($request->role == 11){
        //    $loginurl = '/parent-verify-email/'.$decodeuserid.'/'.$decoderoleid; 
        // }else{
        //     $loginurl = '/user-verify-email/'.$decodeuserid.'/'.$decoderoleid;
        // } 

        
        return redirect($organisation_url.'/admin/user-list')->with('success', 'User Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $organisation_url)
    {
        $id = $request->user_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        // $school = School::where('id',$id)->first();

        $user = User::where('id',$id)->first();
        $organisation_url = $user->organisation_url;

        $organisation = DB::table($organisation_url.'.users')->where('id',$id)->update($input);
        $organisation_main = DB::table('users')->where('id',$id)->update($input);
        return redirect($organisation_url.'/admin/user-list')->with('success', 'User Deleted successfully!');
    }
}
