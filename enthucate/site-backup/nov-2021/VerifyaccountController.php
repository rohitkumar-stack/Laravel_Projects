<?php

namespace App\Http\Controllers\Api;

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
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\School;
use App\Models\UserMeta;

class VerifyaccountController extends Controller
{
    
    public function OrganisationVerify(Request $request, $id)
    {
        // return redirect('/dashboard');
        $userid = base64_decode($id);
        $user = User::where('id',$userid)->where('status','0')->where('is_del','0')->first();
        if(empty($user)){
            return redirect('/login')->with('error', 'Sorry, your Link has been expired!');
        }
        return view('verifyaccount.organisationverify',['id'=>$id,'user'=>$user]);
    }
    public function UserVerify(Request $request, $id, $role)
    {
        // return redirect('/dashboard');
        $userid = base64_decode($id);
        $role_id = base64_decode($role);
        $user = User::where('id',$userid)->where('status','0')->where('is_del','0')->first();
        if(empty($user)){
            return redirect('/login')->with('error', 'Sorry, your Link has been expired!');
        }
        return view('verifyaccount.userverify',['id'=>$id,'user'=>$user,'role_id'=>$role_id]);
    }
    public function AddTeacher(Request $request)
    {
        $schools = School::where('is_del','0')->get();
        $country = Country::get();
        $data[] = array('schools'=>$schools,'country'=>$country);
        $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $data,
        ];
        return response()->json($response);
    }
    public function ParentVerify(Request $request, $id, $role)
    {
        // return redirect('/dashboard');
        $userid = base64_decode($id);
        $role_id = base64_decode($role);
        $user = User::where('id',$userid)->where('status','0')->where('is_del','0')->first();
        if(empty($user)){
            return redirect('/login')->with('error', 'Sorry, your Link has been expired!');
        }
        $schools = School::where('organisation_id',$user->organisation_id)->get();
        return view('verifyaccount.parentverify',['id'=>$id,'user'=>$user,'role_id'=>$role_id,'schools'=> $schools]);
    }
    public function StudentVerify(Request $request, $id, $role)
    {
        // return redirect('/dashboard');
        $userid = base64_decode($id);
        $role_id = base64_decode($role);
        $user = User::where('id',$userid)->where('status','0')->where('is_del','0')->first();
        if(empty($user)){
            return redirect('/login')->with('error', 'Sorry, your Link has been expired!');
        }
        $schools = School::where('organisation_id',$user->organisation_id)->get();
        return view('verifyaccount.studentverify',['id'=>$id,'user'=>$user,'role_id'=>$role_id,'schools'=> $schools]);
    }
     public function NewPassword(Request $request, $id)
    {
        $userid = base64_decode($id);
        $user = User::where('id',$userid)->first();
        return view('verifyaccount.newpassword',['id'=>$id,'user'=>$user]);
    }
    public function CreateParentAccount(Request $request)
    {
        $id = $request->id;
        
        $user = User::find($request->id);
        $user->password = bcrypt($request->password);
        $user->status = '1';
        $user->mobile_number = $request->mobile_number;
        //$user->school_id = $request->school;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        $input['password']=$user->password; 
        $input['status']=$user->status;
        $input['mobile_number']=$user->mobile_number;
        //$input['school_id']=$user->school_id;
        $input['first_name']=$user->first_name;
        $input['last_name']=$user->last_name;
        $schoolvalue = DB::table($user->organisation_url.'.users')->where('id',$request->id)->update($input);

        unset($input['password']);
        unset($input['confirmed']);
        unset($input['first_name']);
        unset($input['last_name']);
        unset($input['mobile_number']);
        unset($input['_token']);
        unset($input['status']);

        $input['school']=$request->school;
        $input['grade']=$request->grade;
        $input['class']=$request->class;
        $input['student_id']=$request->student_id;        
        foreach ($input as $key => $value) {
            $input_data['role_id']= $user->role_id;
            if(is_array($value)) {
               $values = implode(",",$value); 
            }
            else{
                $values = $value;
            }         
            $input_data['user_id']= $id;
            $input_data['meta_key']= $key;
            $input_data['meta_value']= $values;
            $getusermeta_main = UserMeta::where('user_id',$id)->where('meta_key',$key)->first();
            $getusermeta = DB::table($user->organisation_url.'.user_meta')->where('user_id',$id)->where('meta_key',$key)->first();
            if(empty($getusermeta_main)){
                $user_meta_main = UserMeta::insert($input_data);
                $user_meta = DB::table($user->organisation_url.'.user_meta')->insert($input_data);  
            }
            else{
                $update_school_main = UserMeta::where('user_id',$id)->where('meta_key',$key)->update($input_data);
                $update_school = DB::table($user->organisation_url.'.user_meta')->where('user_id',$id)->where('meta_key',$key)->update($input_data);
            }
            
            
        }
        return redirect('/login')->with('success', 'Congratulations!, Your Account have been Created.');
    }
    public function CreateTeacherAccount(Request $request)
    {
        $id = $request->id;
        $validator = \Validator::make($request->all(), [    
            'school' => 'required',
            'grade' => 'required',
            'class' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => ['required', 'string', 'max:255'],   
            'email' => 'required|email|unique:users',
            'mobile_number'=> 'required|numeric|unique:users',            
            //'mobile_number' => 'required|numeric|unique:users,mobile_number,' . $request->id . ',id',
            // 'email' => 'required|email|unique:users,email,' . $request->id . ',id',
            // 'mobile_number'=> 'required|numeric|unique:users,mobile_number,' . $request->id . ',id',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            $errormsg = $validator->errors()->getMessages();
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>$errormsg, //$validator->errors(),
            ];
            return response()->json($response); 
        }
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789'); // and any other characters
        shuffle($seed);
        $JoinID = '';
        foreach (array_rand($seed, 6) as $k) {
            $JoinID .= $seed[$k];
        }
        $JoinID;
        $school = School::find($request->school);
        $org = User::where('organisation_id',$school->organisation_id)->first();

        if(isset($request->id) && $request->id != ''){
            $user = User::find($request->id); 
        }
        else{
            $user = new User(); 
            $user->role_id = '9';
            $user->organisation_id = $school->organisation_id;
            $user->school_id = $request->school; 
            $user->organisation_url = $org->organisation_url;
            $user->JoinID = $org->JoinID;
            $user->email = $request->email;
            $user->user_type = 'user';

            $input['role_id']='9'; 
            $input['organisation_id']=$school->organisation_id;
            $input['organisation_url']=$org->organisation_url;
            $input['school_id']=$request->school;
            $input['email']=$request->email;
            $input['JoinID']=$JoinID;
            $input['user_type']='user'; 
        }        
        $user->password = bcrypt($request->password);
        $user->status = '1';
        $user->mobile_number = $request->mobile_number;
        //$user->school_id = $request->school;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        $input['password']=$user->password; 
        $input['status']=$user->status;
        $input['mobile_number']=$user->mobile_number;
        //$input['school_id']=$user->school_id;
        $input['first_name']=$user->first_name;
        $input['last_name']=$user->last_name;
        if(isset($request->id) && $request->id != ''){
            $schoolvalue = DB::table($user->organisation_url.'.users')->where('id',$request->id)->update($input);
        }
        else{
            $input['id']=$user->id;
             $schoolvalue = DB::table($user->organisation_url.'.users')->insert($input);
        }

        unset($input['password']);
        unset($input['confirmed']);
        unset($input['first_name']);
        unset($input['last_name']);
        unset($input['mobile_number']);
        unset($input['status']);

        $input['school']=$request->school;
        $input['grade']=$request->grade;
        $input['class']=$request->class;
        foreach ($input as $key => $value) {
            
            
                $input_data['role_id']= $user->role_id;
                if(is_array($value)) {
                   $values = implode(",",$value); 
                } 
                else{
                    $values = $value;
                }         
                $input_data['user_id']= $user->id;
                $input_data['meta_key']= $key;
                $input_data['meta_value']= $values;
                $getusermeta_main = UserMeta::where('user_id',$id)->where('meta_key',$key)->first();
                $getusermeta = DB::table($user->organisation_url.'.user_meta')->where('user_id',$id)->where('meta_key',$key)->first();
                if(empty($getusermeta_main)){
                    $user_meta_main = UserMeta::insert($input_data);
                    $user_meta = DB::table($user->organisation_url.'.user_meta')->insert($input_data);  
                }
                else{
                    $update_school_main = UserMeta::where('user_id',$id)->where('meta_key',$key)->update($input_data);
                    $update_school = DB::table($user->organisation_url.'.user_meta')->where('user_id',$id)->where('meta_key',$key)->update($input_data);
                }
           // }
            
            // print_r($input_data);
            
            
        }
        $response = [
                'code' => 200,
                'success' => true,
                'message' => 'error',
                'data' =>'Your Account have been Created.', //$validator->errors(),
            ];
            return response()->json($response); 
        // return redirect('/login')->with('success', 'Congratulations!, Your Account have been Created.');
    }
    public function SaveOrganisation(Request $request)
    {
        $userid = base64_encode($request->id);
        $validator = \Validator::make($request->all(), [       
            //'mobile_number' => 'required|numeric|unique:users,mobile_number,' . $request->id . ',id',
            'email' => 'required|email|unique:users,email,' . $request->id . ',id',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            if($request->type == 'crateorganisation'){
                // return redirect('/organisation-verify-email/'.$userid)
                // ->withErrors($validator)
                // ->withInput();
                return Redirect::back()
                ->withErrors($validator)
                ->withInput();
            }
            if($request->type == 'newpassword'){
                return Redirect::back()
                ->withErrors($validator)
                ->withInput();
                // return redirect('/new-password/'.$userid)
                // ->withErrors($validator)
                // ->withInput();
            }
            
        } else {
            $user = User::find($request->id);
            $user->password = bcrypt($request->password);
            $user->status = '1';
            $user->save();

            $input['password']=$user->password; 
            $input['status']=$user->status;
            $school = DB::table($user->organisation_url.'.users')->where('id',$request->id)->update($input);

            return redirect('/login')->with('success', 'Congratulations!, Your new password have been updated.');
        }
    }
    
    public function ExistChildForm(Request $request){
        $role_id = 10;
        $topicprofiles = DB::table('users')->where('id', $request->join_id)->where('role_id', $role_id)->first();
        if(empty($topicprofiles)){
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>$topicprofiles, //$validator->errors(),
            ];
            return response()->json($response); 
        }
        $schoolinfos = DB::table('user_meta'); 
        $schoolinfos->join('school', 'school.id', '=', 'user_meta.meta_value');
        $schoolinfos->select('school.school_name');
        $schoolinfos->where('user_meta.user_id', $request->join_id);
        $schoolinfos->where('user_meta.meta_key', 'school');
        $schoolinfo = $schoolinfos->first();

        $gradeinfos = DB::table('user_meta'); 
        $gradeinfos->join('grade', 'grade.id', '=', 'user_meta.meta_value');
        $gradeinfos->select('grade.grade_name');
        $gradeinfos->where('user_meta.user_id', $request->join_id);
        $gradeinfos->where('user_meta.meta_key', 'grade');
        $gradeinfo = $gradeinfos->first();

        $classinfos = DB::table('user_meta'); 
        $classinfos->join('classes', 'classes.id', '=', 'user_meta.meta_value');
        $classinfos->select('classes.class_name');
        $classinfos->where('user_meta.user_id', $request->join_id);
        $classinfos->where('user_meta.meta_key', 'class');
        $classinfo = $classinfos->first();

        $data_result =  array();
        $studentinfo = '<div class="form-group add_student_info" >
                            <span class="mt-5">School</span>
                            <div class="student_school">'.$schoolinfo->school_name.'</div>
                            <span class="mt-5">Grade</span>
                            <div class="student_school">'.$gradeinfo->grade_name.'</div>
                            <span class="mt-5">Class</span>
                            <div class="student_school">'.$classinfo->class_name.'</div>
                        </div>';
        $studentinid = ' <div class="form-group">
                            <input type="text" class="form-control exist_first_name" name="first_name" value="'.$topicprofiles->first_name.'" placeholder="First Name" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control exist_last_name" name="first_name" class="form-control" value="'.$topicprofiles->last_name.'" placeholder="First Name" required />
                        </div>
                        <input type="hidden" id="my_student_id" name="student_id" value="'.$request->join_id.'" />
                        ';
         $data_result  = array('studentinfo'=>$studentinfo,'studentinid'=>$studentinid);
         $response = [
                'code' => 200,
                'success' => false,
                'message' => 'error',
                'data' =>$data_result, //$validator->errors(),
            ];
            return response()->json($response); 
    }
    public function AddNewChild(Request $request){

        $validator = \Validator::make($request->all(), [    
            'school' => 'required',
            'grade' => 'required',
            'class' => 'required',   
            'email' => 'required|string|email|max:255|unique:users',
          'mobile_number'=> 'required|numeric|unique:users',
        ]);
        if ($validator->fails()) {
            $errormsg = $validator->errors()->getMessages();
            $data = array();
            if(isset($errormsg['school'][0])){
                $data['school'] = $errormsg['school'][0];
            }
            if(isset($errormsg['grade'][0])){
                $data['grade'] = $errormsg['grade'][0]; 
            }
            if(isset($errormsg['class'][0])){
                $data['class'] = $errormsg['class'][0]; 
            }
            if(isset($errormsg['email'][0])){
                $data['email'] = $errormsg['email'][0]; 
            }
            if(isset($errormsg['mobile_number'][0])){
                $data['mobile_number'] = $errormsg['mobile_number'][0]; 
            }
             $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>$data, //$validator->errors(),
            ];
            return response()->json($response); 
        }
        
        $topicprofiles = DB::table('school')->where('school.is_del', '0'); 
        $topicprofiles->join('organisation', 'organisation.id', '=', 'school.organisation_id');
        $topicprofiles->join('users', 'users.organisation_id', '=','organisation.id' );
        $topicprofiles->select('users.organisation_id','users.organisation_url');
        $topicprofiles->where('school.id',$request->school);
        $topicprofile = $topicprofiles->first();
        $role = 10;
        $organisation_url = $topicprofile->organisation_url;
        $input['organisation_id']=$topicprofile->organisation_id;
        $input['first_name']=$request->child_first_name;
        $input['last_name']=$request->child_last_name;
        $input['mobile_number']=$request->mobile_number;
        $input['school_id']=$request->school;
        $input['email']=$request->email;
        $input['role_id']=$role;
        $input['position_title']=$request->position_title; 
        $input['organisation_url']=$organisation_url;       
        //$input['created_by']=Auth::User()->id;

        $school_main = User::insert($input);
        $id = DB::getPdo()->lastInsertId();
        $input['id']=$id;        
        $school = DB::table($organisation_url.'.users')->insert($input);
        $schoolvalue = DB::table($organisation_url.'.users')->where('id',$request->id)->update($input);

        unset($input['first_name']);
        unset($input['last_name']);
        unset($input['mobile_number']);
        unset($input['_token']);
        unset($input['status']);

        $input['school']=$request->school;
        $input['grade']=$request->grade;
        $input['class']=$request->class;
        foreach ($input as $key => $value) {        
            $input_data['role_id']= $role;
            if(is_array($value)) {
               $values = implode(",",$value); 
            } 
            else{
                $values = $value;
            }         
            $input_data['user_id']= $id;
            $input_data['meta_key']= $key;
            $input_data['meta_value']= $values;
            // print_r($input_data);
            $getusermeta_main = UserMeta::where('user_id',$id)->where('meta_key',$key)->first();
            $getusermeta = DB::table($organisation_url.'.user_meta')->where('user_id',$id)->where('meta_key',$key)->first();
            if(empty($getusermeta_main)){
                $user_meta_main = UserMeta::insert($input_data);
                $user_meta = DB::table($organisation_url.'.user_meta')->insert($input_data);  
            }
            else{
                $update_school_main = UserMeta::where('user_id',$id)->where('meta_key',$key)->update($input_data);
                $update_school = DB::table($organisation_url.'.user_meta')->where('user_id',$id)->where('meta_key',$key)->update($input_data);
            }
        }
        // $userinfos = DB::table('users'); 
        // $userinfos->join('school', 'school.id', '=', 'users.school_id');
        // $userinfos->select('users.id','users.first_name','users.last_name','school.school_name');
        // $userinfos->where('users.id', $id);
        // $userinfo = $userinfos->first();
        // $data_result =  array();
        // $studentinfo = '<div class="form-group add_student_info" >
        //                     <span class="mt-5">Name</span>
        //                     <div class="student_school">'.$userinfo->first_name.' '.$userinfo->last_name.'</div>
        //                     <span class="mt-5">School</span>
        //                     <div class="student_school">'.$userinfo->school_name.'</div>
        //                 </div>';
        // $studentinid = '<input type="hidden" name="student_id[]" value="'.$id.'" />';
        //  $data_result  = array('studentinfo'=>$studentinfo,'studentinid'=>$studentinid);
        //  $response = [
        //         'code' => 200,
        //         'success' => false,
        //         'message' => 'error',
        //         'data' =>$data_result, //$validator->errors(),
        //     ];
        //     return response()->json($response); 

        $schoolinfos = DB::table('user_meta'); 
        $schoolinfos->where('user_meta.user_id', $request->parent_id);
        $schoolinfos->where('user_meta.meta_key', 'student_id');
        $schoolinfo = $schoolinfos->first();
        $oldstudent_id[] = $id;
        $studentids = array();
        if(!empty($schoolinfo)){
            $studentids = explode(',', $schoolinfo->meta_value);
        }

        $newstudent_id = array_merge($oldstudent_id,$studentids);
        $userinfos = DB::table('users'); 
        $userinfos->join('school', 'school.id', '=', 'users.school_id');
        $userinfos->select('users.id','users.first_name','users.last_name','school.school_name');
        $userinfos->whereIn('users.id', $newstudent_id);
        $userinfos = $userinfos->get();
        $data_result =  array();
        $studentinfo = '';
        $studentinid = '';
        foreach ($userinfos as $key => $userinfo) {        
            $studentinfo .= '<div class="form-group add_student_info" >
                                <span class="mt-5">Name</span>
                                <div class="student_school">'.$userinfo->first_name.' '.$userinfo->last_name.'</div>
                                <span class="mt-5">School</span>
                                <div class="student_school">'.$userinfo->school_name.'</div>
                            </div>';
            $studentinid .= '<input type="hidden" name="student_id[]" value="'.$userinfo->id.'" />';
            
         }
         $data_result  = array('studentinfo'=>$studentinfo,'studentinid'=>$studentinid);
         $response = [
                'code' => 200,
                'success' => false,
                'message' => 'error',
                'data' =>$data_result, //$validator->errors(),
            ];
            return response()->json($response);
    }
    public function UpdateExistChildForm(Request $request){
        $schoolinfos = DB::table('user_meta'); 
        $schoolinfos->where('user_meta.user_id', $request->parent_id);
        $schoolinfos->where('user_meta.meta_key', 'student_id');
        $schoolinfo = $schoolinfos->first();
        $oldstudent_id[] = $request->student_id;
        $studentids = array();
        if(!empty($schoolinfo)){
            $studentids = explode(',', $schoolinfo->meta_value);
        }

        $newstudent_id = array_merge($oldstudent_id,$studentids);
        // print_r($newstudent_id);

        $userinfos = DB::table('users'); 
        $userinfos->join('school', 'school.id', '=', 'users.school_id');
        $userinfos->select('users.id','users.first_name','users.last_name','school.school_name');
        $userinfos->whereIn('users.id', $newstudent_id);
        $userinfos = $userinfos->get();
        $data_result =  array();
        $studentinfo = '';
        $studentinid = '';
        foreach ($userinfos as $key => $userinfo) {        
            $studentinfo .= '<div class="form-group add_student_info" >
                                <span class="mt-5">Name</span>
                                <div class="student_school">'.$userinfo->first_name.' '.$userinfo->last_name.'</div>
                                <span class="mt-5">School</span>
                                <div class="student_school">'.$userinfo->school_name.'</div>
                            </div>';
            $studentinid .= '<input type="hidden" name="student_id[]" value="'.$userinfo->id.'" />';
            
         }
         $data_result  = array('studentinfo'=>$studentinfo,'studentinid'=>$studentinid);
         $response = [
                'code' => 200,
                'success' => false,
                'message' => 'error',
                'data' =>$data_result, //$validator->errors(),
            ];
            return response()->json($response);
    }
    
    
}