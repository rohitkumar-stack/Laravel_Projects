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
use App\Models\School;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Group;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index()
    {
        $results = Classes::where('is_del','0')->get();
        $organisations = Organisation::where('is_del','0')->get();
        return view('superadmin.class.class',['results'=>$results,'organisations'=>$organisations]);
    }
    public function ClassList(Request $request)
    {
        $start = $_REQUEST['start'];
        $limit = $_REQUEST['length'];
        $search = $_REQUEST['search']['value'];
        if($_REQUEST['organisation'] != '' && $_REQUEST['schools'] == ''){
          $order_count= Classes::where('is_del','0')->where('organisation_id',$_REQUEST['organisation']);
          
        }
        elseif($_REQUEST['schools'] != '' && $_REQUEST['grades'] == ''){
            $order_count= Classes::where('is_del','0')->where('organisation_id',$_REQUEST['organisation'])->where('school_id',$_REQUEST['schools']);
        }
        elseif($_REQUEST['grades'] != ''){
            $order_count= Classes::where('is_del','0')->where('organisation_id',$_REQUEST['organisation'])->where('school_id',$_REQUEST['schools'])->where('grade_id',$_REQUEST['grades']);
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
        $result= Classes::where('is_del','0');
        if($_REQUEST['organisation'] != '' && $_REQUEST['schools'] == ''){
          $result->where('organisation_id',$_REQUEST['organisation']);
        }
        elseif($_REQUEST['schools'] != '' && $_REQUEST['grades'] == ''){
            $result= Classes::where('is_del','0')->where('organisation_id',$_REQUEST['organisation'])->where('school_id',$_REQUEST['schools']);
        }
        elseif($_REQUEST['grades'] != ''){
            $result= Classes::where('is_del','0')->where('organisation_id',$_REQUEST['organisation'])->where('school_id',$_REQUEST['schools'])->where('grade_id',$_REQUEST['grades']);
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
        foreach ($result as $key => $order) {
            $order_key++;          
            $organisation = Organisation::where('id', $order->organisation_id)->first();
            $school = School::where('id', $order->school_id)->first();
            $grade = Grade::where('id', $order->grade_id)->first();
           

          $action = '';
           $action = '<div class="d-flex">
            <a href="'.url('/superadmin/edit-class/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markclassdelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteclass" title="Delete class" data-placement="right" ><i class="fa fa-trash"></i></a>
            </div>';

          $client_data[] = array(
            'orderno'=>"#$order_key",
            'organisation_name'=>$organisation->organisation_name,
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $roletypes = RoleType::where('is_del','0')->get();
        $hierarchys = Hierarchy::where('is_del','0');        
        $hierarchys = $hierarchys->get();
        $hierarchyLicense = Hierarchy::where('is_del','0')->get(); 
        $countries = Country::get();
        $organisations = Organisation::where('is_del','0')->get(); 

        return view('superadmin.class.addclass',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries,'organisations'=>$organisations]);
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
            'organisation' => 'required',
            'school' => 'required',
            'grade' => 'required',
            'class_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $organisation_url = '';
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
        
        return redirect('/superadmin/class-list')->with('success', 'Class added successfully!'); 
            
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
    public function edit($id)
    {
        $class = Classes::where('id',$id)->first();
        $schools = School::where('organisation_id',$class->organisation_id)->get();
        $grades = Grade::where('school_id',$class->school_id)->get();

        return view('superadmin.class.editclass',['class'=>$class,'schools'=>$schools,'grades'=>$grades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        $school_main = Classes::where('id',$id)->update($input);                
        $school = DB::table($organisation_url.'.classes')->where('id',$id)->update($input);
        return redirect('/superadmin/class-list')->with('success', 'Class Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->class_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $grade = Classes::where('id',$id)->first();
        $user = User::where('organisation_id',$grade->organisation_id)->first();
        $organisation_url = $user->organisation_url;


        $organisation = DB::table($organisation_url.'.classes')->where('id',$id)->update($input);
        $organisation_main = DB::table('classes')->where('id',$id)->update($input);
        return redirect('/superadmin/class-list')->with('success', 'Class Deleted successfully!');
    }
}
