<?php

namespace App\Http\Controllers;

use App\Lib\PusherFactory;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Models\Messagechat;
use App\Models\User;
use App\Models\NotificationToken;
use Redirect;
use Mail;
use DB;
use Session;
use Config;
use File;
use Auth;
use App\Models\Message;
use App\Models\MessageChatStatus;
use App\Models\Department;
use App\Models\Group;

class MessagechatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * getLoadLatestMessages
     *
     *
     * @param Request $request
     */
    public function getLoadLatestMessages(Request $request)
    {
        if (!$request->user_id) {
            return;
        }
        $userids = '';
        $messagestatus = '';
        $messages = Message::where('id', $request->user_id)->first();
        if(Auth::User()->role_id != '1'){
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
        $messagesk = Messagechat::where(function ($query) use ($request,$userid,$organisation_ids) {
          $query->where('to_user', 'LIKE', '%,' . $userid . ',%');
          $query->orWhere('to_user', 'LIKE', '%,' . $userid . '');
          $query->orWhere('to_user', 'LIKE', '' . $userid . ',%');
          $query->orWhere('to_user', $userid);
          $query->orWhere('from_user', $userid); 
          $query->orwhereIn('organisation_id', $organisation_ids); 
        })->select('message_chat.*')->where('message_id', $request->user_id)->orderBy('message_chat.created_at', 'DESC')->limit(10)->get();

        if($messages->message_type == 'department'){
          if(!empty($messages->type_id)){
            $department = Department::where('id',$messages->type_id);
            $department->where(function ($query) use ($request,$userid,$organisation_ids) {
            $query->where('members', 'LIKE', '%,' . $userid . ',%');
            $query->orWhere('members', 'LIKE', '%,' . $userid . '');
            $query->orWhere('members', 'LIKE', '' . $userid . ',%');
            $query->orWhere('members', $userid);
            $query->orWhere('created_by', $userid); 
            $query->orwhereIn('organisation_id', $organisation_ids); 
          });
            $messagestatus = $department->count();
            // $userids  = $department->members;
          }
        }
        elseif($messages->message_type == 'group'){
          if(!empty($messages->type_id)){
              $group = Group::where('id',$messages->type_id)->where('is_del','0')->first();
              $group->where(function ($query) use ($request,$userid,$organisation_ids) {
              $query->where('members', 'LIKE', '%,' . $userid . ',%');
              $query->orWhere('members', 'LIKE', '%,' . $userid . '');
              $query->orWhere('members', 'LIKE', '' . $userid . ',%');
              $query->orWhere('members', $userid);
              $query->orWhere('created_by', $userid); 
              $query->orwhereIn('organisation_id', $organisation_ids); 
            });
              $messagestatus = $group->count();
             
          }
        }
        elseif($messages->message_type == 'school'){
          if(!empty($messages->type_id)){ 
             $users = User::whereIn('role_id',$messages->recipients)->whereIn('school_id',$messages->type_id)->where('is_del','0')->get(); 
             $schooluserid = '';
             foreach ($users as $key => $schoolser) {
               $schooluserid .= $schoolser->id.',';
             }
             $userids = rtrim($schooluserid,",");
          }
        }

      }
      else{
        $messagesk = Messagechat::where(function ($query) use ($request) {
            $query->where('message_id', $request->user_id);
        })->orWhere(function ($query) use ($request) {
                $query->where('message_id', $request->user_id);
            })->select('message_chat.*')->orderBy('message_chat.created_at', 'DESC')->limit(10)->get();
      }

        $return = [];
        $getallmember = [];
        foreach ($messagesk as $key => $value) {
            $getallmember[] = $value;
        }
        usort($getallmember, [$this, "unreadcomparator"]);
        foreach ($getallmember as $message) {
            //$return[] = view('admin.message-line')->with('message', $message)->render();
            $return[] = view('superadmin.message-line')
                ->with('message', $message)
                ->render();
        }

        return response()->json(['state' => 1, 'messages' => $return, 'message_status'=>$messagestatus]);
    }
    function unreadcomparator($object1, $object2)
    {
        return $object1->id > $object2->id ? 1 : -1;
    }

    /**
     * postSendMessage
     *
     * @param Request $request
     */
    public function postSendMessage(Request $request)
    {
        // if(!$request->to_user || !$request->message) {
        //     return;
        // }
       
      $userids = '';
      $organisation_url = '';
        $messages = Message::where('id', $request->to_user)->first();
        //$userids = $messages->members;

        if($messages->message_type == 'department'){
        if(!empty($messages->type_id)){
          $department = Department::where('id',$messages->type_id)->where('is_del','0')->first();
          $userids  = $department->members;
        }
      }
      elseif($messages->message_type == 'group'){
        if(!empty($messages->type_id)){
           $group = Group::where('id',$messages->type_id)->where('is_del','0')->first();
           $userids  = $group->members;
           
        }
      }
      elseif($messages->message_type == 'school'){
        if(!empty($messages->type_id)){ 
           $users = User::whereIn('role_id',$messages->recipients)->whereIn('school_id',$messages->type_id)->where('is_del','0')->get(); 
           $schooluserid = '';
           foreach ($users as $key => $schoolser) {
             $schooluserid .= $schoolser->id.',';
           }
           $userids = rtrim($schooluserid,",");
        }
      }

        $org = User::where('organisation_id', $messages->organisation_id)->first();
        $organisation_url = $org->organisation_url;

        $attachment = '';
        if (isset($request->ReminderImages)) {
            foreach ($request->ReminderImages as $key => $images) {
                $getexp = explode('!!', $images);
                $imagename = $getexp[0];
                $getimage = explode('base64,', $images);
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
        // if(!empty($userids)){
        //$user_ids = explode(',', $userids);
        //if(!empty($user_ids)){
        $inputdata['id'] = '';
        //foreach ($user_ids as $key => $userid) {
        //if(auth()->user()->id != $userid) {
        $message = new Messagechat();
        $message->from_user = auth()->user()->id;
        $message->to_user = $userids;
        $message->organisation_id = $messages->organisation_id;
        $message->content = $request->message;
        $message->message_id = $request->to_user;
        $message->attachment = $attachment;
        $message->save();

        $inputdata['id'] = $message->id;
        $inputdata['attachment'] = $attachment;
        $inputdata['organisation_id'] = $messages->organisation_id;
        $inputdata['message_id'] = $request->to_user;
        $inputdata['from_user'] = auth()->user()->id;
        $inputdata['to_user'] = $userids;
        $inputdata['content'] = $request->message;

        $schoolresult = DB::table($organisation_url . '.message_chat')->insert($inputdata);

        $inputdatachat['userid']=auth()->user()->id; 
        $inputdatachat['message_chat_id']=$message->id; 
        $inputdatachat['message_id'] = $request->to_user;
        $inputdatachat['status'] = '1';
        $inputdatachat['created_at']=date('Y-m-d H:i:s');
        $inputdatachat['updated_at']=date('Y-m-d H:i:s');

        $messagestatus = DB::table('message_chat_status')->insert($inputdatachat);
        $idmsg = DB::getPdo()->lastInsertId();
        $inputdatachat['id']=$idmsg; 

        $messagestatusorg = DB::table($organisation_url.'.message_chat_status')->insert($inputdatachat);



        $message->dateTimeStr = date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()));
        $message->dateHumanReadable = $message->created_at->diffForHumans();
        $attachmentvalue = '';
        if (!empty($message->attachment)) {
            $getnote_images = explode(',', $message->attachment);
            foreach ($getnote_images as $key => $getnote_image) {
                $getexpimage = explode('.', $getnote_image);
                //$bytes = filesize(getcwd() ."/images/messages/" . $getnote_image);
                $byte = ''; //$this->formatSizeUnits($bytes);
                $attachmentvalue .=
                    '<div class="preview_image_container preview_image_container_reply  result_preview_img_' .
                    $message->id .
                    '_' .
                    $key .
                    ' " id="result_preview_img_' .
                    $message->id .
                    '_' .
                    $key .
                    ' ">                                       
                                   <div class="new-sec">
                                      <div class="inner d-flex align-items-center">
                                         <div class="img-sec">';
                $attachmentvalue .= ' <i class="fa fa-file"></i>';

                $attachmentvalue .=
                    '</div>
                                         <div class="text-sec">
                                            <p>' .
                    $getnote_image .
                    '</p>
                                            <span>' .
                    $byte .
                    '</span>
                                         </div>
                                         <div class="download-ico">
                                          <a href=' .
                    asset("/images/messages/" . $getnote_image) .
                    ' download> <i class="fa fa-download"></i></a>
                                         </div>';

                $attachmentvalue .= '</div>
                                   </div>
                                </div>
                                ';
            }
        }


        $message->fromUserName = $message->fromUser->name;
        $message->from_user_id = auth()->user()->id;
        //$message->toUserName = $message->toUser->name;
        //$message->toUserpic = $message->toUser->profile_pic;
        $message->to_user_id = $request->to_user;
        $message->attachment = $attachmentvalue;

        PusherFactory::make()->trigger('chat', 'send', ['data' => $message]);
        return response()->json(['state' => 1, 'data' => $message]);
        
    }

    /**
     * getOldMessages
     *
     * we will fetch the old messages using the last sent id from the request
     * by querying the created at date
     *
     * @param Request $request
     */
    public function getOldMessages(Request $request)
    {
        if (!$request->old_message_id || !$request->to_user) {
            return;
        }

        $message = Messagechat::find($request->old_message_id);
        if(Auth::User()->role_id != '1'){
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

          $lastMessages = Messagechat::where(function ($query) use ($request, $message,$userid,$organisation_ids) {
            $query->where('to_user', 'LIKE', '%,' . $userid . ',%');
            $query->orWhere('to_user', 'LIKE', '%,' . $userid . '');
            $query->orWhere('to_user', 'LIKE', '' . $userid . ',%');
            $query->orWhere('to_user', $userid);
            $query->orWhere('from_user', $userid); 
            $query->orwhereIn('organisation_id', $organisation_ids); 
        })->where('message_id', $request->to_user)->where('created_at', '<', $message->created_at)->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get(); 

        }
        else{
          $lastMessages = Messagechat::where(function ($query) use ($request, $message) {
            // $query->where('from_user', auth()->user()->id)
            //      ->where('to_user', $request->to_user)
            $query->where('message_id', $request->to_user);
            $query->where('created_at', '<', $message->created_at);
        })
            ->orWhere(function ($query) use ($request, $message) {
                // $query->where('from_user', $request->to_user)
                //     ->where('to_user', auth()->user()->id)
                $query->where('message_id', $request->to_user);
                $query->where('created_at', '<', $message->created_at);
            })
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get(); 
        }
        
        $return = [];

        if ($lastMessages->count() > 0) {
            foreach ($lastMessages as $message) {
                $return[] = view('superadmin.message-line')
                    ->with('message', $message)
                    ->render();
            }

            PusherFactory::make()->trigger('chat', 'oldMsgs', ['to_user' => $request->to_user, 'data' => $return]);
        }

        return response()->json(['state' => 1, 'data' => $return]);
    }

    public function ReadMessage(Request $request)
    {
        $UserId = auth()->user()->id;
        $messages = Message::where('id', $request->user_id)->first();
        $organisation_url = '';

        $org = User::where('organisation_id', $messages->organisation_id)->first();
        $organisation_url = $org->organisation_url;

        $messagechats = Messagechat::where('message_id', $request->user_id)->get();
        foreach ($messagechats as $key => $messagechat) {
            $messagecount = MessageChatStatus::where('message_chat_id', '=', $messagechat->id)
                ->where('userid', '=', Auth::User()->id)
                ->count();
            if ($messagecount == 0) {
                $getmember = new MessageChatStatus();
                $getmember->userid = Auth::User()->id;
                $getmember->message_chat_id = $messagechat->id;
                $getmember->message_id = $request->user_id;
                $getmember->status = '1';
                $getmember->save();

                $inputdata['id'] = $getmember->id;
                $inputdata['userid'] = $getmember->userid;
                $inputdata['message_chat_id'] = $getmember->message_chat_id;
                $inputdata['message_id'] = $getmember->message_id;
                $inputdata['status'] = '1';

                $schoolresult = DB::table($organisation_url . '.message_chat_status')->insert($inputdata);
            }
        }

        return 1;
    }
}
