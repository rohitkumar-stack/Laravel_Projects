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
                      @if($error == 'The password format is invalid.')
                      <li>Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.</li>
                      @else
                      <li>{{ $error }}</li>
                      @endif
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
                                    <h4 class="text-center mb-4 text-white">Sign in your account</h4>
                                   <form method="POST" action="{{ route('login') }}">
                                     @csrf
                                     <input type="hidden" name="status" value="1">
                                     <input type="hidden" name="is_del" value="0">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email/Mobile Number</strong></label>
                                            <input type="text" class="form-control email" id="email" name="email" @if(Cookie:: has('adminuser')) value="{{ Cookie::get('adminuser') }}" @else value="{{ old('email') }}" @endif placeholder="Enter Email/Mobile Number">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Password</strong></label>
                                            <input type="password" id="password" name="password" class="form-control password" @if(Cookie:: has('adminpassword')) value="{{ Cookie::get('adminpassword') }}"  @endif placeholder="Enter Password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1 text-white">
                                                    <input type="checkbox" class="custom-control-input remember_me" id="remember_me" name="remember_me" value="1" @if(Cookie:: has('adminuser'))  checked  @endif >
                                                    <label class="custom-control-label" for="remember_me">Remember my preference</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a class="text-white" href="{{ url('password-forgot') }}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                   <!--  <div class="new-account mt-3">
                                        <p class="text-white">Don't have an account? <a class="text-white" href="{{ route('register') }}">Sign up</a></p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
