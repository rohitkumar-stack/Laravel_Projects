<?php

namespace App\Http\Controllers;

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

class PasswordController extends Controller
{
    
    public function PasswordForgot(Request $request)
    {  
        return view('password.passwordforgor');
    }
    public function VarifyOtp(Request $request)
    {  
        $otp = $request->digit_1.$request->digit_2.$request->digit_3.$request->digit_4;
        $user = User::where('email', $request->email)->where('otp',$otp)->first();
        if(!empty($user)){
            $user->otp = null;
            $user->save();
            
            return redirect('/new-password/'.base64_encode($user->id))->with('success', 'Your code has been verified. Please Enter new password!');
        }else{
            return redirect('/otp/'.base64_encode($request->email) )->with('error', 'Please, Enter valid Verification code!');
        }
        die();
        return view('password.passwordforgor');
    }
    public function OTP(Request $request,$id)
    {
         $decodeuserid = base64_decode($id);
    return view('password.otp',['email'=>$decodeuserid]);
    }
    public function resendcode(Request $request,$id)
    {
         $request->email = $id;
         $result = $this->ForgotPassword($request, $id);
          return redirect('/otp/'.$result->getData()->data )->with('success', 'Verification code has been sent to your email!');
        
         
    }
    public function ForgotPassword(Request $request,$id= '')
    {
        if($id ==''){
            $validator = \Validator::make($request->all(), [       
                'email' => 'required|email|unique:users,email,' . $request->email . ',email',
            ]);

            if ($validator->fails()) {
                return redirect('/password-forgot/')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
            $user = User::where('email', $request->email)->first();
            if(!empty($user)){
               
                // generate OTP
                $otp = rand(1000,9999);
                $user->otp = $otp;
                $user->save();
                // Send OTP

                $TWILIO_SID= Config::get('app.TWILIO_SID');
                $TWILIO_TOKEN=Config::get('app.TWILIO_TOKEN');
                $FROM_NUMBER=Config::get('app.FROM_NUMBER');

                 $userphonenumber =$request->email;
                 // GET /2010-04-01/Accounts/ACXXXXX.../Messages/SM1f0e8ae6ade43cb3c0ce4525424e404f

                $message = $otp.' is your Enthucate verification code.';

           //      Mail::send('emails.otp',['otp' => $message,'email'=>$user->email], function($message) use ($user) {
           //    $message->to($user->email);
           //    $message->subject('Enthucate Password Reset');
           // });
                $number = base64_encode($user->email);
                if($id != ''){
                    $response = [
                        'code' => 200,
                        'success' => true,
                        'message' => "",
                        'data'    => $number,
                    ];
                    return response()->json($response);
                    // exit;
                }
                else{
                 return redirect('/otp/'.$number)->with('success', 'Verification code has been sent to your email!'); 
                }
              // $id = $TWILIO_SID;
              // $token = $TWILIO_TOKEN;
              // $url = "https://api.twilio.com/2010-04-01/Accounts/".$id."/SMS/Messages";
              // $from = $FROM_NUMBER;

              //   $clientphonenumber = $userphonenumber;
              //   $data = array (
              //   'From' => $from,
              //   'To' => $clientphonenumber,
              //   'Body' => $message,
              //   );
              //   $post = http_build_query($data);
              //   $x = curl_init($url );
              //   curl_setopt($x, CURLOPT_POST, true);
              //   curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
              //   curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
              //   curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
              //   curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
              //   curl_setopt($x, CURLOPT_POSTFIELDS, $post);
              //   $y = curl_exec($x);
              //   curl_close($x);
              //   $array = json_decode(json_encode(simplexml_load_string($y)),1);
              //   echo '<pre>';
              //   print_r($array);
    
            }
            else{
              return redirect('/password-forgot')->with('error', "We can't find a user with that Email.")->withInput();   
            }
    }
    
}