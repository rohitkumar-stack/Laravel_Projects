<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use Session;
use Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use ThrottlesLogins;

    protected $redirectTo = '/home';
    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 1; // Default is 1

    public function __construct()
    {

        $this->middleware(['guest'])->except('logout');
    }

    public function username()
    {
        return 'email';
        //return 'mobile_number';
    }
    public function mobile_number()
    {
      return 'mobile_number';
    }
    public function logout(Request $request)
    {
        // die('hlo');
        // $request->session()->flush();
        // $request->session()->regenerate();
        Auth::logout();
       
        return redirect('/login');
    }
     public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [       
            'email' => 'required',
            'password' => 'required',
        ]);
         $remember_me = $request->has('remember_me') ? true : false; 
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
            ->withInput()->withInput($request->all());
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if(is_numeric($request->email)){
             $mobile_number = $request->email;
             
            $credentials = $request->only($mobile_number, 'password','status','is_del');
            $credentials['mobile_number'] = $mobile_number;
        }
        elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $credentials = $request->only('email', 'password','status','is_del');
        }

        // print_r($credentials);
        // die('jk');
        if(is_numeric($request->email)){
            $data = [
                "mobile_number" => $credentials['mobile_number'],
                "password" => $credentials['password'],
                "status" => $credentials['status'],
                "is_del" => $credentials['is_del'],
            ];
            $rules = [
                'mobile_number' => 'required',
                'password' => 'required'
            ];
        }
        elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $data = [
                "email" => $credentials['email'],
                "password" => $credentials['password'],
                "status" => $credentials['status'],
                "is_del" => $credentials['is_del'],
            ]; 
            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];  
        }
        $validator = Validator::make($data, $rules);

        if (!$validator->fails()) {

            if (Auth::attempt($credentials,$remember_me)) {
                $user = auth()->user();
                if($request->has('remember_me')){
                   Cookie::queue('adminuser',$request->email,1440);
                   Cookie::queue('adminpassword',$request->password,1440);  
                }
                else{
                    Cookie::queue(Cookie::forget('adminuser'));
                    Cookie::queue(Cookie::forget('adminpassword'));
                }
                return redirect()->intended('home');
            } else {
                $this->incrementLoginAttempts($request);
                if(is_numeric($request->email)){
                    $users = User::where('mobile_number',$request->email);
                    $users->where(function ($query) use ($request) {
                    $query->where('status', '0')
                        ->orWhere('is_del', '1');
                    });
                    $users = $users->first();
                }
                elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $users = User::where('email',$request->email);
                    $users->where(function ($query) use ($request) {
                    $query->where('status', '0')
                        ->orWhere('is_del', '1');
                    });
                    $users = $users->first();
                }
                if(!empty($users)){
                  return redirect()->back()
                    ->withInput($request->all())
                    ->with(['error' => "Your Account is not active or deleted. Please check your email for verify the account."]);  
                }
                return redirect()->back()
                    ->withInput($request->all())
                    ->with(['error' => 'Please check your username / password.']);

            }

        } else {
            return redirect('login')->withErrors($validator)->withInput();
        }


    }  

    protected function authenticated(Request $request, $user) {
        if($user->role_id == '1'){
            return redirect()->intended('superadmin');
        }else if($user->role_id == '2'){
            return redirect()->intended($user->organisation_url.'/admin');
        }else{
            return redirect()->intended($user->organisation_url.'/');
        }
    }
}
