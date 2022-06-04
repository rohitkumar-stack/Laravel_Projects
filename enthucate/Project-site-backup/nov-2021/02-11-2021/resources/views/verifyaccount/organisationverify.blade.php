@extends('layouts.app') @section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                @if(session()->has('success'))
                <div class="alert alert-success" id="successMessage" style="white-space: pre-line;">{{ session()->get('success') }}</div>
                @endif @if(session()->has('error'))
                <div class="alert alert-danger" id="errorMessage">
                    {{ session()->get('error') }}
                </div>
                @endif @if ($errors->any())
                <div class="alert alert-danger" id="errorMessage">
                    <ul>
                        @foreach ($errors->all() as $error) @if($error == 'The password format is invalid.')
                        <li>Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.</li>
                        @else
                        <li>{{ $error }}</li>
                        @endif @endforeach
                    </ul>
                </div>
                <br />
                @endif
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                </div>
                                <h4 class="text-center mb-4 text-white">Sign up your account</h4>
                                <form method="post" action="{{url('save-organisation-password')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}" />
                                    <input type="hidden" name="type" value="crateorganisation" />
                                    <div class="form-group">
                                        <label class="mb-1 text-white"><strong>Email</strong></label>
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}" placeholder="Email" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1 text-white"><strong>Create Password</strong></label>
                                        <input type="password" name="password" class="form-control" value="" placeholder="Create Password" />
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1 text-white" for="password-confirm"><strong>Confirm Password</strong></label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn bg-white text-primary btn-block">Save new password</button>
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
