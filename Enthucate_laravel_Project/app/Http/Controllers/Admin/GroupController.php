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
use App\Models\Group;
use App\Models\RolesPermissionMeta;

class GroupController extends Controller
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
        $results =  DB::table($organisation_url.'.group')->whereIn('organisation_id',$organisation_ids)->where('is_del','0')->get();

        return view('admin.group.group',['results'=>$results]);
    }
    public function GroupList(Request $request)
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
         $order_count= DB::table($organisation_url.'.group')->whereIn('organisation_id',$organisation_ids)->where('is_del','0');
        if($_REQUEST['organisation'] != ''){
          $order_count->where('organisation_id',$_REQUEST['organisation']);
          
        }
        
        if($search != ''){
        $order_count->where(function($query) use ($search){
          $query->where('group_name', 'LIKE', '%' . $search . '%');
          $query->orWhere('description', 'LIKE', '%' . $search . '%');
        });
      }
      $order_count = $order_count->count();
        $result= DB::table($organisation_url.'.group')->whereIn('organisation_id',$organisation_ids)->where('is_del','0');
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

        $group_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','group_delete')->first();
        $group_edit = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','group_edit')->first();


        foreach ($result as $key => $order) {
          $order_key++;
          

          $action = '';

          $action .= '<div class="d-flex">';
          if(isset($group_add->meta_value) && $group_add->meta_value == 'on'){
            $action .= '<a href="'.url(Auth::User()->organisation_url.'/admin/edit-group/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>';
          }
          if(isset($group_edit->meta_value) && $group_edit->meta_value == 'on' && $order->created_by == Auth::User()->id){
            $action .= '<a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markschooldelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteschool" title="Delete School" data-placement="right" ><i class="fa fa-trash"></i></a>
            ';
          }
          $action .= '</div>';

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
        $group_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','group_add')->first();
        if(empty($group_add)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
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
        // $organisation_id = array(); 
        $organisation_ids = array_merge($organisationid,$organisation_id);

        $members = User::where('is_del','0')->where('status','1')->where('user_type','=','user')->whereIn('organisation_id',$organisation_ids)->get(); 
        $getorganisations =  DB::table('organisation')->whereIn('id',$organisation_ids)->where('is_del','0')->get();
        return view('admin.group.addgroup',['members'=>$members,'organisations'=>$getorganisations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request, $organisation_url)
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
        return redirect($organisation_url.'/admin/group-list')->with('success', 'group added successfully!'); 
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
        $group_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','group_edit')->first();
        if(empty($group_add)){
            return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
        }
        $group = Group::where('id',$id)->first();

         $organisationid = array();
        $organisation_url = Auth::User()->organisation_url;
        // $organisationid[] = Auth::User()->organisation_id;
        $organisationid[] = $group->organisation_id;
        $userid = Auth::User()->id;
        $getgrganisationbyid = $this->GetOrganisationById($userid,$organisation_url);
        // if(!empty($getgrganisationbyid)){
        //     $organisation_id = $getgrganisationbyid['organisations'];
        // }
        // else{
        //     $organisation_id = array();
        // } 
        $organisation_id = array();
        $organisation_ids = array_merge($organisationid,$organisation_id);

        $members = User::where('is_del','0')->where('status','1')->where('user_type','=','user')->whereIn('organisation_id',$organisationid)->get(); 

        return view('admin.group.editgroup',['group'=>$group, 'members'=>$members]);
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
        return redirect($organisation_url.'/admin/group-list')->with('success', 'group Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $organisation_url)
    {
        $id = $request->school_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $school = Group::where('id',$id)->first();

        $organisation = DB::table($organisation_url.'.group')->where('id',$id)->update($input);
        $organisation_main = DB::table('group')->where('id',$id)->update($input);
        return redirect($organisation_url.'/admin/group-list')->with('success', 'group Deleted successfully!');
    }
}
