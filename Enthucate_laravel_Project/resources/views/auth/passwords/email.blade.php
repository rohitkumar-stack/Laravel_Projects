@extends('layouts.app')

@section('content')
<div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                    <div class="text-center mb-3">
                                        <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">Forgot Password</h4>
                                   <form method="POST" action="{{ route('password.email') }}">
                                     @csrf
                                        <div class="form-group">
                                            <label class="text-white"><strong>Email</strong></label>
                                            <!-- <input type="email" class="form-control" value="hello@example.com"> -->
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
@endsection
