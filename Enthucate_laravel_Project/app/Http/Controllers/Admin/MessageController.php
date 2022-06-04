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
use App\Models\Message;
use App\Models\RolesPermissionMeta;
use App\Models\Messagecategory;
use App\Models\Department;
use App\Models\Group;
use App\Models\Messagechat;
use App\Models\MessageChatStatus;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function index()
    // {
    //     // $userid = Auth::User()->id;
    //     // $organisation_url = Auth::User()->organisation_url;
    //     // $organisation_id = Auth::User()->organisation_id;
    //     // $results = $this->GetadminOrganisation($userid);
    //     $results = Message::where('is_del','0')->get();
    //     $organisations = Organisation::where('is_del','0')->get();

    //     return view('admin.message.message',['results'=>$results,'organisations'=>$organisations]);
    // }
     public function index(Request $request)
    {
      $getallmember =  $this->chatusers($request);
      $organisations = Organisation::where('is_del','0')->get();
      $messagecategory = Messagecategory::where('is_del','0')->get();
      $getallmembers = $getallmember['getallmember'];
      return view('admin.chat', ['users'=> $getallmembers,'organisations'=>$organisations,'messagecategory'=>$messagecategory]);
    }
    public function chatusers(Request $request)
    {
        
        $organisations = Organisation::where('is_del','0')->get();

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
        // echo '<pre>';
        // print_r($organisation_ids);
        // die('hlo');
        // $users =  DB::table('message');
        $users = Message::where('message.is_del','0');
        $users->where(function($query) use ($userid,$organisation_ids){
          $query->where('members', 'LIKE', '%,' . $userid . ',%');
          $query->orWhere('members', 'LIKE', '%,' . $userid . '');
          $query->orWhere('members', 'LIKE', '' . $userid . ',%');
          $query->orWhere('members', $userid);
          $query->orWhere('message.created_by', $userid);  
          $query->orwhereIn('message.organisation_id', $organisation_ids);         
        });

        if(isset($request->message_priority) && $request->message_priority != ''){
          $users->where('message_priority',$request->message_priority);
        }
        if(isset($request->category) && $request->category != ''){
          $users->where('message_category',$request->category);
        }
        if(isset($request->messagetype) && $request->messagetype != ''){
          if($request->messagetype == 'Inbox'){
              $users->where('message.created_by',Auth::User()->id);
          }
          else{
            $users->where('message.created_by','!=',Auth::User()->id);
          }
          
        }
        $users->leftJoin('users as a1', 'a1.id', '=', 'message.created_by');
        $users->leftJoin('message_chat as a2', 'a2.message_id', '=', 'message.id');
        $users->select('message.*','a1.profile_pic','a2.content','a2.attachment as chat_attachment','a2.created_at','a2.updated_at')->groupBy('a2.message_id');

        $users = $users->get();
        $messagecategory = Messagecategory::where('is_del','0')->get();
        $getallmember = array();
        $totalcount = 0;
        foreach ($users as $key => $user) {
          $countvalue = 0;
          $messagechats = Messagechat::where('message_chat.message_id',$user->id)->get();
          foreach ($messagechats as $key => $messagechat) {
            $messagecount = MessageChatStatus::where('message_chat_id','=', $messagechat->id)->where('userid','=', Auth::User()->id)->count();
            if($messagecount == 0){
              $countvalue += 1;
            } 
          }
          // content
          $messagechatcontent = Messagechat::where('message_chat.message_id',$user->id);
          $messagechatcontent->where(function($query) use ($userid,$organisation_ids){
            $query->where('to_user', 'LIKE', '%,' . $userid . ',%');
            $query->orWhere('to_user', 'LIKE', '%,' . $userid . '');
            $query->orWhere('to_user', 'LIKE', '' . $userid . ',%');
            $query->orWhere('to_user', $userid);
            $query->orWhere('from_user', $userid);  
            $query->orwhereIn('organisation_id', $organisation_ids);         
          });
          $messagechatcontent = $messagechatcontent->orderBy('id', 'DESC')->first();
          // echo '<pre>';
          // print_r($messagechatcontent);
          $totalcount += $countvalue;
          $user->dateTimeStr = date("Y-m-dTH:i", strtotime($user->created_at->toDateTimeString()));
          $user->dateHumanReadable = $user->created_at->diffForHumans();

          $user->content = $messagechatcontent->content;
          $user->message_created_at = strtotime($user->created_at);
          $user->message_updated_at = strtotime($user->updated_at);
          $user->message_created = date("Y-m-dTH:i", strtotime($user->created_at)); 
          $user->countmessage = $countvalue;         
          $getallmember[] = $user;
        }
        // die('hlo');
        usort($getallmember,array($this, "unreadcomparator"));
        $data = array('getallmember'=>$getallmember,'totalcount'=>$totalcount);
        return $data;
        // return view('admin.chat',['users'=>$users,'organisations'=>$organisations,'messagecategory'=>$messagecategory]);
    }
    function unreadcomparator($object1, $object2) { 
        return ($object1->message_updated_at < $object2->message_updated_at) ? 1 : -1; 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $message_add = RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','message_add')->first();
      if(empty($message_add)){
          return redirect(Auth::User()->organisation_url.'/admin')->with('error', "You don't have permission of that page!");
      }

        $roletypes = RoleType::where('is_del','0')->get();
        $hierarchys = Hierarchy::where('is_del','0');        
        $hierarchys = $hierarchys->get();
        $hierarchyLicense = Hierarchy::where('is_del','0')->get(); 
        $countries = Country::get();
        $organisations = Organisation::where('is_del','0')->get();

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
        $departments =  DB::table($organisation_url.'.department')->whereIn('organisation_id',$organisationid)->where('is_del','0')->get();
        $groups =  DB::table($organisation_url.'.group')->whereIn('organisation_id',$organisationid)->where('is_del','0')->get();
        $schools =  DB::table($organisation_url.'.school')->whereIn('organisation_id',$organisationid)->where('is_del','0')->get();
        $messagecategory = Messagecategory::where('is_del','0')->get();

        return view('admin.message.addmessage',['roletypes'=>$roletypes,'hierarchys'=>$hierarchys,'hierarchyLicense'=>$hierarchyLicense,'countries'=>$countries,'organisations'=>$organisations,'departments'=>$departments,'groups'=>$groups,'schools'=>$schools,'messagecategory'=>$messagecategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->message_type == 'department'){
        $validator = \Validator::make($request->all(), [
            'organisation' => 'required',
            'department' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'message_priority' => 'required',
            'message_category' => 'required',
        ]);
      }
      if($request->message_type == 'group'){
        $validator = \Validator::make($request->all(), [
            'organisation' => 'required',
            'group' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'message_priority' => 'required',
            'message_category' => 'required',
        ]);
      }
      if($request->message_type == 'school'){
        $validator = \Validator::make($request->all(), [
            'organisation' => 'required',
            'school' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'message_priority' => 'required',
            'message_category' => 'required',
            'recipients' => 'required',
        ]);
      } 
      $type_id = '';
      $userids = '';
      if ($validator->fails()) {
          return Redirect::back()->withErrors($validator)->withInput();
      }
      if($request->message_type == 'department'){
        if(!empty($request->department)){
          $type_id = implode(",",$request->department);
          $department = Department::where('id',$request->department)->where('is_del','0')->first();
          $userids  = $department->members;
        }
      }
      elseif($request->message_type == 'group'){
        if(!empty($request->group)){
           $type_id = implode(",",$request->group); 
           $group = Group::where('id',$request->group)->where('is_del','0')->first();
           $userids  = $group->members;
           
        }
      }
      elseif($request->message_type == 'school'){
        if(!empty($request->school)){
           $type_id = implode(",",$request->school); 
           $users = User::whereIn('role_id',$request->recipients)->whereIn('school_id',$request->school)->where('is_del','0')->get(); 
           $schooluserid = '';
           foreach ($users as $key => $schoolser) {
             $schooluserid .= $schoolser->id.',';
           }
           $userids = rtrim($schooluserid,",");
        }
      }
        
        $attachment = '';
        if(isset($request->ReminderImages)){
          foreach ($request->ReminderImages as $key => $images) {
            $getexp = explode('!!',$images);
            $imagename = $getexp[0];            
            $getimage = explode('base64,',$images);
            $note_images = $getimage[1];                    
            $newImageName = $imagename;
            $uploadFileDir = base_path() . '/images/messages/';
            $dest_path = $uploadFileDir . $newImageName;
            if (file_put_contents($dest_path, base64_decode($note_images))) {                       
                $dataimage[] = $newImageName;
            }
          }
          $attachment = implode(",", $dataimage);
        }
        $organisation_url = '';
        $org = User::where('organisation_id',$request->organisation)->first();
        $organisation_url = $org->organisation_url;
        $input['organisation_id']=$request->organisation;
        $input['subject']=$request->subject;
        $input['message']=$request->message;
        $input['type_id']=$type_id;
        $input['attachment']=$attachment;
        $input['message_type']=$request->message_type;
        $input['message_priority']=$request->message_priority;
        $input['message_category']=$request->message_category;
        $input['members']=$userids;
        //$input['whatsapp']=$request->whatsapp;
        $input['userid']=$org->id;
        $input['created_by']=Auth::User()->id;
        $input['created_at']=date('Y-m-d H:i:s');
        $input['updated_at']=date('Y-m-d H:i:s');

        $school_main = Message::insert($input);
        $id = DB::getPdo()->lastInsertId();
        $input['id']=$id;        
        $school = DB::table($organisation_url.'.message')->insert($input);

       // if(!empty($userids)){
          //$user_ids = explode(',', $userids);
          //if(!empty($user_ids)){
          $inputdata['id']= '';
            //foreach ($user_ids as $key => $userid) { 
              //if(auth()->user()->id != $userid) {
                $message = new Messagechat();
                $message->from_user = auth()->user()->id;
                $message->to_user = $userids;
                $message->organisation_id = $request->organisation;
                $message->content = $request->message;
                $message->message_id = $id;
                $message->attachment = $attachment;  
                $message->save();

                $inputdata['id']=$message->id;
                $inputdata['attachment']=$attachment; 
                $inputdata['organisation_id'] = $request->organisation;
                $inputdata['message_id']=$id; 
                $inputdata['from_user'] = auth()->user()->id;
                $inputdata['to_user'] = $userids;
                $inputdata['content'] = $request->message;
                $inputdata['created_at']=date('Y-m-d H:i:s');
                $inputdata['updated_at']=date('Y-m-d H:i:s');
                        
                $schoolresult = DB::table($organisation_url.'.message_chat')->insert($inputdata);

                // $inputdatachat['id']=$getmember->id;
                $inputdatachat['userid']=auth()->user()->id; 
                $inputdatachat['message_chat_id']=$message->id; 
                $inputdatachat['message_id'] = $id;
                $inputdatachat['status'] = '1';
                $inputdatachat['created_at']=date('Y-m-d H:i:s');
                $inputdatachat['updated_at']=date('Y-m-d H:i:s');

                $messagestatus = DB::table('message_chat_status')->insert($inputdatachat);
                $idmsg = DB::getPdo()->lastInsertId();
                $inputdatachat['id']=$idmsg; 

                $messagestatusorg = DB::table($organisation_url.'.message_chat_status')->insert($inputdatachat);


              //}
            //}
          //}
        //}

        return redirect($organisation_url.'/admin/message-list')->with('success', 'Message has been added successfully!'); 
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
        $message = Message::where('id',$id)->first();
        $members = User::where('is_del','0')->where('user_type','=','user')->where('organisation_id',$message->organisation_id)->get(); 

        return view('admin.message.editmessage',['message'=>$message,'members'=>$members]);
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
            'message_name' => 'required',
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
        $input['message_name']=$request->message_name;
        $input['description']=$request->description;
        $input['create_members']=$create_members;
        $input['members']=$members;
        //$input['whatsapp']=$request->whatsapp;
        $input['userid']=$org->id;
        $input['created_by']=Auth::User()->id;

        $school_main = Message::where('id',$id)->update($input);     
        $school = DB::table($organisation_url.'.message')->where('id',$id)->update($input);
        return redirect('/admin/message-list')->with('success', 'message Updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         $id = $request->message_id;
        $input['is_del']='1';
        $input['deleted_at']=date('Y-m-d H:i:s');
        $input['deleted_by']=Auth::User()->id;

        $school = Message::where('id',$id)->first();

        $user = User::where('organisation_id',$school->organisation_id)->first();
        $organisation_url = $user->organisation_url;


        $organisation = DB::table($organisation_url.'.message')->where('id',$id)->update($input);
        $organisation_main = DB::table('message')->where('id',$id)->update($input);
        return redirect('/admin/message-list')->with('success', 'message Deleted successfully!');
    }
}
