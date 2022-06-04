@extends('layouts.app') @section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
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
                                <div class="text-center mb-3">
                                    <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                </div>
                                <h4 class="text-center mb-4 text-white">Forgot Password</h4>
                                <form method="POST" action="{{ url('passwordforgot') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="text-white"><strong>Email</strong></label>
                                        <!-- <input type="email" class="form-control" value="hello@example.com"> -->
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email" />
                                    </div>
                                    <div class="text-center mt-4">
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
@endsection
