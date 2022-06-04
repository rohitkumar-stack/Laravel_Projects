<?php
   
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
//use App\Models\NotificationToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Str;


   
class RegisterController extends Controller
{
    use ThrottlesLogins;
    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 1; // Default is 1
    public function username()
    {
        return 'email';
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */   
    public function register(Request $request)
    {
        $token = Str::random(80);
        $api_token = hash('sha256', $token);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>'Too many attempts. Please try again in '.$seconds.' seconds',
            ];
             return response()->json($response);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number'=> 'required|numeric|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', 
            'alias' => ['required', 'string', 'max:255', 'unique:users'],         
            'agree' => 'required',
        ]);   
        if($validator->fails()){
        	$errormsg = $validator->errors()->getMessages();
        	$data = array();
        	if(isset($errormsg['first_name'][0])){
        	 	$data['first_name'] = $errormsg['first_name'][0];
        	}
        	if(isset($errormsg['last_name'][0])){
        	 	$data['last_name'] = $errormsg['last_name'][0]; 
        	}
            if(isset($errormsg['alias'][0])){
                $data['alias'] = $errormsg['alias'][0]; 
            }
        	if(isset($errormsg['email'][0])){
        	 	$data['email'] = $errormsg['email'][0]; 
        	}
            if(isset($errormsg['phone_number'][0])){
                $data['phone_number'] = $errormsg['phone_number'][0]; 
            }
        	 if(isset($errormsg['password'][0])){
        	 	if($errormsg['password'][0] == 'The password format is invalid.'){
        	 		$data['password'] = 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'; 
        	 	}
        	 	else{
        	 		$data['password'] = $errormsg['password'][0]; 
        	 	}
        	 	
        	 }
        	 if(isset($errormsg['agree'][0])){
        	 	$data['agree'] = $errormsg['agree'][0]; 
        	 }
        	// print_r($data);
            $this->incrementLoginAttempts($request);
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>$data, //$validator->errors(),
            ];
            return response()->json($response);      
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 'user';
        $input['total_message'] = '5000';
        $input['total_upload_size'] = '500';
        $input['active'] = '0';
        $user = User::create($input);
        $success['token'] =  $api_token;
        $success['result'] =  $user;   
        
        Mail::send('auth.verifyemail',['name' => $request->first_name,'email'=>$request->email], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Notekeeping Verify Your Account');
        });
        $response = [
            'code' => 200,
            'success' => true,
            'message' => 'User register successfully.',
            'data'    => $success,
        ];
        return response()->json($response);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
    	$notetodomemberu = NotificationToken::where('userid', $request->userid)
                    ->where('Notification_Token', $request->Notification_Token)
                    ->delete();
        $response = [
        'code' => 200,
        'success' => true,
        'message' => 'User Logout successfully.',
        'data'    => '',                
        ];
        return response()->json($response);
    }
    public function login(Request $request)
    {
        $token = Str::random(80);
        $api_token = hash('sha256', $token);
         if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>'Too many attempts. Please try again in '.$seconds.' seconds',
            ];
             return response()->json($response);
        }
        if(is_numeric($request->email)){
            if(Auth::attempt(['phone_number' => $request->email, 'password' => $request->password, 'status' => '1'])){ 
                $user = Auth::user(); 
              //   if(!empty($request->ip_address)){
              //     $notetodomemberu = NotificationToken::where('ip_address', $request->ip_address)->where('type', $request->type)->delete();  
              //   }
              //   $notificationtoken = NotificationToken::where('userid',$user->id)->where('Notification_Token',$request->Notification_Token)->first();
              //   if(empty($notificationtoken)){
              //     $notificationtoken = new NotificationToken();  
              // }                
                // $notificationtoken->userid = $user->id;
                // $notificationtoken->Notification_Token = $request->Notification_Token;
                // $notificationtoken->type = $request->type;
                // $notificationtoken->ip_address = $request->ip_address;
                // $notificationtoken->device_name = $request->device_name;
                // $notificationtoken->save();
                 $success['token'] =  $api_token;
                $success['result'] =  $user;       
                $response = [
                    'code' => 200,
                    'success' => true,
                    'message' => 'User login successfully.',
                    'data'    => $success,                
                ];
                return response()->json($response);
            }
            else{ 
                $this->incrementLoginAttempts($request);
                if(is_numeric($request->email)){
                    $users = User::where('phone_number',$request->email)->where('status', '0')->first();
                }
                elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $users = User::where('email',$request->email)->where('status', '0')->first();
                }
                if(!empty($users)){                 
                    $response = [
                        'code' => 404,
                        'success' => false,
                        'message' => 'error',
                        'data' =>'Your Account is not active. Please check your email for verify the account.',
                    ];
                    return response()->json($response);  
                }
                $response = [
                    'code' => 404,
                    'success' => false,
                    'message' => 'error',
                    'data' =>'Please check your username / password',
                ];
                return response()->json($response);
            } 
        }
        elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => '1'])){ 
                $user = Auth::user();
                // if(!empty($request->ip_address)){
                //   $notetodomemberu = NotificationToken::where('ip_address', $request->ip_address)->where('type', $request->type)->delete();
                // }
                 
                // $notificationtoken = NotificationToken::where('userid',$user->id)->where('Notification_Token',$request->Notification_Token)->first();
                // if(empty($notificationtoken)){
                //   $notificationtoken = new NotificationToken();  
                // }  
                // $notificationtoken->userid = $user->id;
                // $notificationtoken->Notification_Token = $request->Notification_Token;
                // $notificationtoken->type = $request->type;
                // $notificationtoken->ip_address = $request->ip_address;
                // $notificationtoken->device_name = $request->device_name;
                // $notificationtoken->save();
                $success['token'] =  $api_token;
                $success['result'] =  $user;       
                $response = [
                    'code' => 200,
                    'success' => true,
                    'message' => 'User login successfully.',
                    'data'    => $success,                
                ];
                return response()->json($response);
            }
            else{ 
                $this->incrementLoginAttempts($request);
                if(is_numeric($request->email)){
                    $users = User::where('phone_number',$request->email)->where('status', '0')->first();
                }
                elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $users = User::where('email',$request->email)->where('status', '0')->first();
                }
                if(!empty($users)){                 
                    $response = [
                        'code' => 404,
                        'success' => false,
                        'message' => 'error',
                        'data' =>'Your Account is not active. Please check your email for verify the account.',
                    ];
                    return response()->json($response);  
                }
                $response = [
                    'code' => 404,
                    'success' => false,
                    'message' => 'error',
                    'data' =>'Please check your username / password',
                ];
                return response()->json($response);
            }
        }
        else{ 
            $this->incrementLoginAttempts($request);
            if(is_numeric($request->email)){
                $users = User::where('phone_number',$request->email)->where('status', '0')->first();
            }
            elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $users = User::where('email',$request->email)->where('status', '0')->first();
            }
            if(!empty($users)){                 
                $response = [
                    'code' => 404,
                    'success' => false,
                    'message' => 'error',
                    'data' =>'Your Account is not active. Please check your email for verify the account.',
                ];
                return response()->json($response);  
            }
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'error',
                'data' =>'Please check your username / password',
            ];
            return response()->json($response);
        } 
    }
    
}
