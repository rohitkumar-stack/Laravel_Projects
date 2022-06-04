@extends('layouts.app')

@section('content')
<div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                 @if(session()->has('success'))
                    <div class="alert alert-success" id="successMessage" style="white-space: pre-line;">{{ session()->get('success') }}</div>
                 @endif
                  @if(session()->has('error'))
                     <div class="alert alert-danger" id="errorMessage">
                          {{ session()->get('error') }}
                      </div>
                  @endif
                   @if ($errors->any())
                    <div class="alert alert-danger" id="errorMessage">
                       <ul>
                          @foreach ($errors->all() as $error)                                      
                          <li>{{ $error }}</li>
                          @endforeach
                       </ul>
                    </div>
                    <br />
                    @endif
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">                                
                                    <div class="text-center mb-3">
                                        <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">Forgot Password</h4>
                                    <p class="text-white">We've sent you the verification code. Please Enter below to reset your password</p>
                                   <form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off" action="{{ url('varify-otp') }}">
                                   <input type="hidden" name="email" value="{{$email}}">
                                     @csrf
                                        <div class="form-group">
                                            <input type="text" id="digit_1" name="digit_1" data-next="digit_2" required />
                                            <input type="text" id="digit_2" name="digit_2" data-next="digit_3" data-previous="digit_1" required />
                                            <input type="text" id="digit_3" name="digit_3" data-next="digit_4" data-previous="digit_2" required />
                                            <input type="text" id="digit_4" name="digit_4" data-next="digit_5" data-previous="digit_3" required />
                                            
                                        </div>
                                        <p  class="text-white" >Didn't receive email? 
                                        <a class="text-white resendpassword" href="{{ url('resendcode')}}/{{$email}}">Resend Code</a>
                                         </p>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
   .digit-group input {
    width: 50px;
    height: 50px;
    border: none;
    line-height: 50px;
    text-align: center;
    font-size: 24px;
    font-weight: 200;
    margin: 0 5px 0 5px;
}
.digit-group .form-group {
    text-align: center;
}
    </style>
@endsection
