<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Organisation;
use App\Models\RoleType;
use App\Models\Hierarchy;
use Mail;
use DB;
use Session;
use Config;
use File;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\School;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Department;
use App\Models\Group;

class HomeController extends Controller
{
  public function subdivision(Request $request){
        $organisations = Organisation::whereIn('hierarchy_id',$request->id)->get();
        $result = '';
        if(!empty($organisations)){
            foreach ($organisations as $key => $organisation) {
              $result .='<option value="'.$organisation->id.'">'.$organisation->organisation_name.'</option>';  
            }
        }
        echo $result;
    }
    public function orgsubdivision(Request $request){
        $organisation_url = Auth::User()->organisation_url;
        $organisations =   DB::table($organisation_url.'.organisation')->whereIn('hierarchy_id',$request->id)->get();
        $result = '';
        if(!empty($organisations)){
            foreach ($organisations as $key => $organisation) {
              $result .='<option value="'.$organisation->id.'">'.$organisation->organisation_name.'</option>';  
            }
        }
        echo $result;
    }

    public function GetCity(Request $request){
      $states = City::where('state_id',$request->id)->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
    public function GetState(Request $request){
      $states = State::where('country_id',$request->id)->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
    public function GetSchool(Request $request){
      $states = School::where('organisation_id',$request->id)->where('is_del','0')->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
     public function GetDepartment(Request $request){
      $states = Department::where('organisation_id',$request->id)->where('is_del','0')->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
    public function GetGread(Request $request){
      $states = Grade::where('school_id',$request->id)->where('is_del','0')->get();

      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
    public function GetClass(Request $request){
      $states = Classes::where('grade_id',$request->id)->where('is_del','0')->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }

    public function GetMember(Request $request){      
      $states = User::where('organisation_id',$request->id)->where('is_del','0')->where('status','1')->where('user_type','=','user')->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
    public function GetGroup(Request $request){
      $states = Group::where('organisation_id',$request->id)->where('is_del','0')->get();
      $response = [
            'code' => 200,
            'success' => true,
            'message' => 'error',
            'data' => $states,
        ];
        return response()->json($response);
    }
     public function ViewDepartementMember(Request $request){
      $states = Department::where('id',$request->id)->where('is_del','0')->first();
      $result = '';
        if(!empty($states)){
          $members = array();
          if($states->members != ''){
              $members = explode(',', $states->members);
          }
          $getmembers = User::whereIn('id',$members)->where('is_del','0')->get();
          if(!empty($getmembers)){
            // echo '<pre>';
            foreach ($getmembers as $key => $state) {
              $roles = RoleType::where('id',$state->role_id)->first();
              // print_r($state);
              $result .='<div id="member_'.$state->id.'" class="member_view_div"><span class="member_name">'.$state->name.' ('.$roles->role.') </span> <span class="member_close btn btn-danger shadow btn-xs sharp deletedapartmentid" data-department="'.$request->id.'" data-user="'.$state->id.'" title="Remove Member" data-placement="right"><i class="fa fa-trash"></i></span></div>'; 
            }
          }
            
        }
        if($result == '')
        {
          $result = 'No Member Found.';
        }
        echo $result;
    }
    function deletedapartmentid(Request $request){
        $activity = Department::where('id', $request->id)->first();
        $note_images = explode(',', $activity->members);
        $dataimage = array();
        foreach ($note_images as $key => $value) {
          if($value != $request->userid){
            $dataimage[] = $value;
          }
        }

        $input['members']=implode(",", $dataimage);

        $org = User::where('organisation_id',$activity->organisation_id)->first();
        $organisation_url = $org->organisation_url;
        $school_main = Department::where('id',$request->id)->update($input);     
        $school = DB::table($organisation_url.'.department')->where('id',$request->id)->update($input);
        // if(!empty($getmembers)){
        //   $getmembers->
        // }
        
        echo  json_encode('Image has been deleted');
    }
}