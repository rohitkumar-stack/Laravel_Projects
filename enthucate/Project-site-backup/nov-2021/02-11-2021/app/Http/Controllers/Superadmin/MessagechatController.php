<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;

use App\Lib\PusherFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Messagechat;
use App\Models\User;
use App\Models\NotificationToken;
use Config;
use Session;

class MessagechatController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function getLoadLatestMessages(Request $request)
    {
        if(!$request->user_id) {
            return;
        }

        $messages = Messagechat::where(function($query) use ($request) {
            $query->where('from_user', auth()->user()->id)->where('to_user', $request->user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', auth()->user()->id);
        })->orderBy('created_at', 'ASC')->limit(10)->get();

        $return = [];

        foreach ($messages as $message) {
            $return[] = view('admin.message-line')->with('message', $message)->render();
        }


        return response()->json(['state' => 1, 'messages' => $return]);
    }

    public function postSendMessage(Request $request)
    {
        // if(!$request->to_user || !$request->message) {
        //     return;
        // }

        $message = new Messagechat();

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
                    $filesize = base64_decode($note_images);
                    $size_in_bytes = (int) (strlen(rtrim($filesize, '=')));
                    $size_in_kb    = $size_in_bytes;
                    $use_upload_size += $size_in_kb;                        
                    $dataimage[] = $newImageName;
                }
            }
            $message->attachment = implode(",", $dataimage);            
        }

        $message->from_user = auth()->user()->id;

        $message->to_user = $request->to_user;

        $message->content = $request->message;

        $message->save();


        // prepare some data to send with the response
        $message->dateTimeStr = date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()));

        $message->dateHumanReadable = $message->created_at->diffForHumans();
        $attachmentvalue = '';
        if(!empty($message->attachment)){
                       $getnote_images = explode(',', $message->attachment); foreach ($getnote_images as $key => $getnote_image) { $getexpimage = explode('.', $getnote_image); 
                       $bytes = filesize(getcwd() ."/public/assets/note_image/" . $getnote_image); 
                       $byte = $this->formatSizeUnits($bytes); 
                    $attachmentvalue .='<div class="preview_image_container preview_image_container_reply  result_preview_img_'.$message->id.'_'.$key.' " id="result_preview_img_'.$message->id.'_'.$key.' ">                                       
                       <div class="new-sec">
                          <div class="inner d-flex align-items-center">
                             <div class="img-sec">';
                               //  if($getexpimage[1] == 'jpg' || $getexpimage[1] == 'jpeg' || $getexpimage[1] == 'png'){
                               //   $attachmentvalue .=' <i class="fa fa-file-image"></i> '; 
                               //  }
                               //   else{
                               //    $attachmentvalue .=' <i class="fas fa-file-alt"></i>'; 
                               // } 
                            if($getexpimage[1] == 'jpg' || $getexpimage[1] == 'jpeg' || $getexpimage[1] == 'png'){
                                $attachmentvalue .='<i class="fa fa-file-image"></i>';
                              }
                            else if($getexpimage[1] == 'xlsx' || $getexpimage[1] == 'xls'){
                                $attachmentvalue .='<i class="fa fa-file-excel"></i>';
                            }
                            else if($getexpimage[1] == 'docx' || $getexpimage[1] == 'doc'){
                                $attachmentvalue .='<i class="fas fa-file-word"></i>';
                            }
                            else if($getexpimage[1] == 'pdf'){
                                $attachmentvalue .='<i class="fas fa-file-pdf"></i>';
                            }
                            else if($getexpimage[1] == 'csv'){
                                $attachmentvalue .='<i class="fas fa-file-csv"></i>';
                            }
                            else{
                                $attachmentvalue .=' <i class="fas fa-file-alt"></i>';
                            }  
                             $attachmentvalue .='</div>
                             <div class="text-sec">
                                <p>'.$getnote_image.'</p>
                                <span>'.$byte.'</span>
                             </div>
                             <div class="download-ico">
                              <a href=' .asset("public/assets/note_image/" . $getnote_image) .' download> <i class="fa fa-download"></i></a
                             </div>
                           
                          </div>
                       </div>
                    </div>';
                       }
                       }
                       
        $message->fromUserName = $message->fromUser->name;

        $message->from_user_id = auth()->user()->id;

        $message->toUserName = $message->toUser->name;
        $message->toUserpic = $message->toUser->profile_pic;

        $message->to_user_id = $request->to_user;

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
        if(!$request->old_message_id || !$request->to_user)
            return;

        $message = Messagechat::find($request->old_message_id);

        $lastMessages = Messagechat::where(function($query) use ($request, $message) {
            $query->where('from_user', auth()->user()->id)
                ->where('to_user', $request->to_user)
                ->where('created_at', '<', $message->created_at);
        })
            ->orWhere(function ($query) use ($request, $message) {
            $query->where('from_user', $request->to_user)
                ->where('to_user', auth()->user()->id)
                ->where('created_at', '<', $message->created_at);
        })
            ->orderBy('created_at', 'ASC')->limit(10)->get();

        $return = [];

        if($lastMessages->count() > 0) {

            foreach ($lastMessages as $message) {

                $return[] = view('admin.message-line')->with('message', $message)->render();
            }

            PusherFactory::make()->trigger('chat', 'oldMsgs', ['to_user' => $request->to_user, 'data' => $return]);
        }

        return response()->json(['state' => 1, 'data' => $return]);
    }
}