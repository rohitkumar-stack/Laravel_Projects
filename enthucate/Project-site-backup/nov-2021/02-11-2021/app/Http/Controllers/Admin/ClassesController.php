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
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Group;
use App\Models\RolesPermissionMeta;


class ClassesController extends Controller
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
        $schools = DB::table($organisation_url.'.school')->whereIn('organisation_id',$organisation_ids)->where('is_del','0')->get();
        $results =  DB::table($organisation_url.'.classes')->whereIn('organisation_id',$organisation_ids)->where('is_del','0')->get();
        return view('admin.class.class',['results'=>$results,'schools'=>$schools]);
    }

    public function ClassList(Request $request)
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
        $order_count= DB::table($organisation_url.'.classes')->whereIn('organisation_id',$organisation_ids)->where('is_del','0');
        if($_REQUEST['schools'] != '' && $_REQUEST['grades'] == ''){
            $order_count->where('school_id',$_REQUEST['schools']);
        }
        elseif($_REQUEST['grades'] != ''){
            $order_count->where('school_id',$_REQUEST['schools'])->where('grade_id',$_REQUEST['grades']);
        }
        else{
          $order_count= Classes::where('is_del','0');
        }
        if($search != ''){
        $order_count->where(function($query) use ($search){
          $query->where('class_name', 'LIKE', '%' . $search . '%');
        });
      }
      $order_count = $order_count->count();
        $result=  DB::table($organisation_url.'.classes')->whereIn('organisation_id',$organisation_ids)->where('is_del','0');
        if($_REQUEST['schools'] != '' && $_REQUEST['grades'] == ''){
            $result->where('school_id',$_REQUEST['schools']);
        }
        elseif($_REQUEST['grades'] != ''){
            $result->where('school_id',$_REQUEST['schools'])->where('grade_id',$_REQUEST['grades']);
        }
         if($search != ''){
        $result->where(function($query) use ($search){
          $query->where('class_name', 'LIKE', '%' . $search . '%');
        });
      }
        $result->orderBy('id','DESC')->offset($_REQUEST['start'])->limit($_REQUEST['length']);
        $result = $result->get();
        $client_data = array();
        $order_key = $start; 

        $class_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','class_delete')->first();
        $class_edit = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','class_edit')->first();

        foreach ($result as $key => $order) {
            $order_key++;          
            $organisation = Organisation::where('id', $order->organisation_id)->first();
            $school = School::where('id', $order->school_id)->first();
            $grade = Grade::where('id', $order->grade_id)->first();           

            // $action = '';
            // $action = '<div class="d-flex">
            // <a href="'.url(Auth::User()->organisation_url.'/admin/edit-class/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
            // <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markclassdelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteclass" title="Delete class" data-placement="right" ><i class="fa fa-trash"></i></a>
            // </div>';

            $action = '';
          $action .= '<div class="d-flex">';
          if(isset($class_edit->meta_value) && $class_edit->meta_value == 'on'){
            $action .= '<a href="'.url(Auth::User()->organisation_url.'/admin/edit-class/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>';
          }
          if(isset($class_add->meta_value) && $class_add->meta_value == 'on'){
            $action .= '<a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markclassdelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteclass" title="Delete class" data-placement="right" ><i class="fa fa-trash"></i></a>
            ';
          }
          $action .= '</div>';

            $client_data[] = array(
                'orderno'=>"#$order_key",
                //'organisation_name'=>$organisation->organisation_name,
                'school'=>$school->school_name,
                'grade'=>$grade->grade_name,
                'class_name'=>$order->class_name,
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
    public function create()
    {
        $class_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','class_add')->first();
        if(empty($class_add)){
        return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }

        $organisation_id = Auth::User()->organisation_id;
        $schools = School::where('organisation_id',$organisation_id)->get();
        return view('admin.class.addclass',['schools'=>$schools]);
    }
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            // 'organisation' => 'required',
            'school' => 'required',
            'grade' => 'required',
            'class_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        $input['school_id']=$request->school;
        $input['grade_id']=$request->grade;
        $input['class_name']=$request->class_name;
        $input['userid']=$org->id;
        $input['created_by']=Auth::User()->id;

        $school_main = Classes::insert($input);
        $id = DB::getPdo()->lastInsertId();
        $input['id']=$id;        
        $school = DB::table($organisation_url.'.classes')->insert($input);

        // add Group
        $getschool = School::find($request->school);
        $getgrade = Grade::find($request->grade);
        $input_group['organisation_id']=$request->organisation;
        $input_group['group_name']=$getschool->school_name.'-'.$getgrade->grade_name.'-'.$request->class_name;
        $input_group['userid']=$org->id;
        $input_group['created_by']=Auth::User()->id;

        $group_main = Group::insert($input_group);
        $ids = DB::getPdo()->lastInsertId();
        $input_group['id']=$ids;        
        $group = DB::table($organisation_url.'.group')->insert($input_group);



        return redirect($organisation_url.'/admin/class-list')->with('success', 'Class added successfully!'); 
            
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
        $class_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','class_edit')->first();
        if(empty($class_add)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }

        $class = Classes::where('id',$id)->first();
        $schools = School::where('organisation_id',$class->organisation_id)->get();
        $grades = Grade::where('school_id',$class->school_id)->get();

        return view('admin.class.editclass',['class'=>$class,'schools'=>$schools,'grades'=>$grades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $organisation_url, $id)
    {
       
        $validator = \Validator::make($request->all(), [
            //'organisation' => 'required',
            'school' => 'required',
            'grade' => 'required',
            'class_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }



        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        $input['school_id']=$request->school;
        $input['grade_id']=$request->grade;
        $input['class_name']=$request->class_name;
        $input['userid']=$org->id;
        $input['created_by']=Auth::User()->id;

        $school_main = Classes::where('id',$id)->update($input);                
        $school = DB::table($organisation_url.'.classes')->where('id',$id)->update($input);
        return redirect($organisation_url.'/admin/class-list')->with('success', 'Class Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $organisation_url)
    {
        $id = $request->class_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $grade = Grade::where('id',$id)->first();
        $user = User::where('organisation_id',$grade->organisation_id)->first();
        $organisation_url = $user->organisation_url;

        $organisation = DB::table($organisation_url.'.classes')->where('id',$id)->update($input);
        $organisation_main = DB::table('classes')->where('id',$id)->update($input);
        return redirect($organisation_url.'/admin/class-list')->with('success', 'Class Deleted successfully!');
    }
}
