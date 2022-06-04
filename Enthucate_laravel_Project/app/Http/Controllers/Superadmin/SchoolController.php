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
use App\Models\Group;

class SchoolController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $results = School::where('is_del','0')->get();
        $organisations = Organisation::where('is_del','0')->get();
        return view('superadmin.school.school',['results'=>$results,'organisations'=>$organisations]);
    }
    public function SchoolList(Request $request)
    {
        $start = $_REQUEST['start'];
        $limit = $_REQUEST['length'];
        $search = $_REQUEST['search']['value'];
        if($_REQUEST['organisation'] != ''){
          $order_count= School::where('is_del','0')->where('organisation_id',$_REQUEST['organisation']);
          
        }
        else{
          $order_count= School::where('is_del','0');
        }
        if($search != ''){
        $order_count->where(function($query) use ($search){
          $query->where('school_name', 'LIKE', '%' . $search . '%');
          $query->orWhere('school_phone', 'LIKE', '%' . $search . '%');
          $query->orWhere('mobile_number', 'LIKE', '%' . $search . '%');
          $query->orWhere('address', 'LIKE', '%' . $search . '%');
          $query->orWhere('postal_code', 'LIKE', '%' . $search . '%');
        });
      }
      $order_count = $order_count->count();
        $result= School::where('is_del','0');
        if($_REQUEST['organisation'] != ''){
          $result->where('organisation_id',$_REQUEST['organisation']);
        }
         if($search != ''){
        $result->where(function($query) use ($search){
          $query->where('school_name', 'LIKE', '%' . $search . '%');
          $query->orWhere('school_phone', 'LIKE', '%' . $search . '%');
          $query->orWhere('mobile_number', 'LIKE', '%' . $search . '%');
          $query->orWhere('address', 'LIKE', '%' . $search . '%');
          $query->orWhere('postal_code', 'LIKE', '%' . $search . '%');
        });
      }
        $result->orderBy('id','DESC')->offset($_REQUEST['start'])->limit($_REQUEST['length']);
        $result = $result->get();
        $client_data = array();
        $order_key = $start;  
        foreach ($result as $key => $order) {
          $order_key++;
          
            $cityname = $statename = $countryname = $postal_code = '';
            $organisation = Organisation::where('id', $order->organisation_id)->first();                  
            $country = Country::where('id', $order->country)->first();
            $state = State::where('id', $order->state)->first();
            $city = City::where('id', $order->city)->first();
            if(!empty($country)){
                $countryname = $country->name;
            }
            if(!empty($state)){
                $statename = $state->name.', ';
            }
            if(!empty($city)){
                $cityname = $city->name.', ';
            }
            if(!empty($order->postal_code)){
                $postal_code = '-'.$order->postal_code;
            }
           

          $action = '';
           $action = '<div class="d-flex">
            <a href="'.url('/superadmin/edit-school/'.$order->id ).'" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markschooldelete" data-id="'.$order->id.'" data-toggle="modal" data-target="#deleteschool" title="Delete school" data-placement="right" ><i class="fa fa-trash"></i></a>
            </div>';

          $client_data[] = array(
            'orderno'=>"#$order_key",
            'school_name'=>$order->school_name,
            'organisation_name'=>$organisation->organisation_name,
            'address'=>$order->address.', '.$cityname.' '.$statename.' '.$countryname.' '.$postal_code,
            'school_phone'=>$order->school_phone,
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

        return view('superadmin.school.addschool',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries,'organisations'=>$organisations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = null;
        $state = null;
        if(isset($request->state)){
            $state = $request->state;
        }
        if(isset($request->city)){
           $city = $request->city; 
        }
        $validator = \Validator::make($request->all(), [
            'organisation' => 'required',
            'school_name' => 'required',
            'school_phone' => 'required|numeric',
            'emis_number' => 'required|unique:school',
            'address' => 'required',
            'name' => 'required',            
            'mobile_number'=> 'required|numeric',
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
        $input['school_name']=$request->school_name;
        $input['name']=$request->name;
        $input['school_phone']=$request->school_phone;
        $input['mobile_number']=$request->mobile_number;
        //$input['whatsapp']=$request->whatsapp;
        $input['userid']=$org->id;
        $input['address']=$request->address;
        $input['country']=$request->country;
        $input['city']=$city;
        $input['state']=$state;
        $input['emis_number']=$request->emis_number;
        $input['postal_code']=$request->postal_code;
        $input['created_by']=Auth::User()->id;

        $school_main = School::insert($input);
        $id = DB::getPdo()->lastInsertId();
        $input['id']=$id;        
        $school = DB::table($organisation_url.'.school')->insert($input);

        // add Group
        
        $input_group['organisation_id']=$request->organisation;
        $input_group['group_name']=$request->school_name;
        //$input['whatsapp']=$request->whatsapp;
        $input_group['userid']=$org->id;
        $input_group['created_by']=Auth::User()->id;

        $group_main = Group::insert($input_group);
        $ids = DB::getPdo()->lastInsertId();
        $input_group['id']=$ids;        
        $group = DB::table($organisation_url.'.group')->insert($input_group);

        return redirect('/superadmin/school-list')->with('success', 'School added successfully!'); 
            
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
        $school = school::where('id',$id)->first();
        $countries = Country::get();
        $states = State::where('country_id',$school->country)->get();
        $cities = City::where('state_id',$school->state)->get();

        return view('superadmin.school.editschool',['school'=>$school,'countries'=>$countries,'states'=>$states,'cities'=>$cities]);
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
        $city = null;
        $state = null;
        if(isset($request->state)){
            $state = $request->state;
        }
        if(isset($request->city)){
           $city = $request->city; 
        }
        $validator = \Validator::make($request->all(), [
            'organisation' => 'required',
            'school_name' => 'required',
            'school_phone' => 'required|numeric',
            'emis_number' => 'required|unique:school,emis_number,' . $id . ',id',
            'address' => 'required',
            'name' => 'required',            
            'mobile_number'=> 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        //$input['organisation_id']=$request->organisation;
        $input['school_name']=$request->school_name;
        $input['name']=$request->name;
        $input['school_phone']=$request->school_phone;
        $input['mobile_number']=$request->mobile_number;
        $input['whatsapp']=$request->whatsapp;
        //$input['userid']=$org->id;
        $input['address']=$request->address;
        $input['country']=$request->country;
        $input['city']=$city;
        $input['state']=$state;
        $input['emis_number']=$request->emis_number;
        $input['postal_code']=$request->postal_code;
        $input['created_by']=Auth::User()->id;

        $school_main = School::where('id',$id)->update($input);                
        $school = DB::table($organisation_url.'.school')->where('id',$id)->update($input);
        return redirect('/superadmin/school-list')->with('success', 'School Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->school_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $school = School::where('id',$id)->first();

        $user = User::where('organisation_id',$school->organisation_id)->first();
        $organisation_url = $user->organisation_url;


        $organisation = DB::table($organisation_url.'.school')->where('id',$id)->update($input);
        $organisation_main = DB::table('school')->where('id',$id)->update($input);
        return redirect('/superadmin/school-list')->with('success', 'School Deleted successfully!');
    }
}
