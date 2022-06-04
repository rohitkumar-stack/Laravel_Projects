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
use App\Models\Group;


class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // $userid = Auth::User()->id;
        // $organisation_url = Auth::User()->organisation_url;
        // $organisation_id = Auth::User()->organisation_id;
        // $results = $this->GetSuperAdminOrganisation($userid);
        $results = Group::where('is_del','0')->get();
        $organisations = Organisation::where('is_del','0')->get();

        return view('superadmin.group.group',['results'=>$results,'organisations'=>$organisations]);
    }
    public function GroupList(Request $request)
    {
        $start = $_REQUEST['start'];
        $limit = $_REQUEST['length'];
        $search = $_REQUEST['search']['value'];
        if($_REQUEST['organisation'] != ''){
          $order_count= Group::where('is_del','0')->where('organisation_id',$_REQUEST['organisation']);
          
        }
        else{
          $order_count= Group::where('is_del','0');
        }
        if($search != ''){
        $order_count->where(function($query) use ($search){
          $query->where('group_name', 'LIKE', '%' . $search . '%');
          $query->orWhere('description', 'LIKE', '%' . $search . '%');
        });
      }
      $order_count = $order_count->count();
        $result= Group::where('is_del','0');
        if($_REQUEST['organisation'] != ''){
          $result->where('organisation_id',$_REQUEST['organisation']);
        }
         if($search != ''){
        $result->where(function($query) use ($search){
          $query->where('group_name', 'LIKE', '%' . $search . '%');
          $query->orWhere('description', 'LIKE', '%' . $search . '%');
        });
      }
        $result->orderBy('id','DESC')->offset($_REQUEST['start'])->limit($_REQUEST['length']);
        $result = $result->get();
        $client_data = array();
        $order_key = $start;  
        foreach ($result as $key => $order) {
          $order_key++;
          

          $action = '';
           $action = '<div class="d-flex">
            <a href="'.url('/superadmin/edit-group/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markschooldelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteschool" title="Delete School" data-placement="right" ><i class="fa fa-trash"></i></a>
            </div>';

          $client_data[] = array(
            'orderno'=>"#$order_key",
            'group_name'=>$order->group_name,
            'description'=>$order->description,
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
        $members = User::where('is_del','0')->where('user_type','=','user')->get(); 

        return view('superadmin.group.addgroup',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries,'organisations'=>$organisations,'members'=>$members]);
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
            'group_name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $members = '';
        $create_members = '';
        if(!empty($request->members)){
           $members = implode(",",$request->members); 
        }
        // if(!empty($request->create_members)){
        //    $create_members = implode(",",$request->create_members); 
        // }
        $organisation_url = '';
        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        $input['group_name']=$request->group_name;
        $input['description']=$request->description;
        $input['create_members']=$create_members;
        $input['members']=$members;
        //$input['whatsapp']=$request->whatsapp;
        $input['userid']=$org->id;
        $input['created_by']=Auth::User()->id;

        $school_main = Group::insert($input);
        $id = DB::getPdo()->lastInsertId();
        $input['id']=$id;        
        $school = DB::table($organisation_url.'.group')->insert($input);
        return redirect('/superadmin/group-list')->with('success', 'group added successfully!'); 
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
        $group = Group::where('id',$id)->first();
        $members = User::where('is_del','0')->where('status','1')->where('user_type','=','user')->where('organisation_id',$group->organisation_id)->get(); 

        return view('superadmin.group.editgroup',['group'=>$group,'members'=>$members]);
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
            'group_name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $members = '';
        $create_members = '';
        if(!empty($request->members)){
           $members = implode(",",$request->members); 
        }
        // if(!empty($request->create_members)){
        //    $create_members = implode(",",$request->create_members); 
        // }
        $organisation_url = '';
        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        $input['group_name']=$request->group_name;
        $input['description']=$request->description;
        $input['create_members']=$create_members;
        $input['members']=$members;
        //$input['whatsapp']=$request->whatsapp;
        $input['userid']=$org->id;
        $input['created_by']=Auth::User()->id;

        $school_main = Group::where('id',$id)->update($input);     
        $school = DB::table($organisation_url.'.group')->where('id',$id)->update($input);
        return redirect('/superadmin/group-list')->with('success', 'group Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         $id = $request->group_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $school = Group::where('id',$id)->first();

        $user = User::where('organisation_id',$school->organisation_id)->first();
        $organisation_url = $user->organisation_url;


        $organisation = DB::table($organisation_url.'.group')->where('id',$id)->update($input);
        $organisation_main = DB::table('group')->where('id',$id)->update($input);
        return redirect('/superadmin/group-list')->with('success', 'group Deleted successfully!');
    }
}
