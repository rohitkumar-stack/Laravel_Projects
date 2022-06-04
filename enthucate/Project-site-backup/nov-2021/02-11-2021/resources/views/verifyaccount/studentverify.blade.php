@extends('layouts.app') @section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center user_type_login">
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
                                <h4 class="text-center text-white">Create account for Student</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="authincation-content-s">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                               
                                <form method="post" action="{{url('create-teacher-account')}}" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="text-primary title-text mb-4">GENERAL INFO</div>
                                    <input type="hidden" name="id" value="{{$user->id}}" />
                                    <input type="hidden" name="type" value="crateorganisation" />
                                    <input type="hidden" class="form-control" name="email" value="{{$user->email}}" />
                                        <div class="form-group notshow selectschool" id="divschool" data-id="0">
                                            <label>School <span class="requried">*</span></label>
                                            <select class="form-control selectschoolvalue notshow clonschool selectschoolvalue_0" id="selectschoolvalue" data-value="0" name="school" required>
                                            <option value="">Select School</option>
                                            @if(!empty($schools))
                                                    @foreach($schools as $school)
                                                        <option value="{{$school->id}}">{{$school->school_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group selectgrade notshow" id="divgrade" data-id="0">
                                            <label>Grade <span class="requried">*</span></label>
                                            <select class="form-control selectgradevalue notshow selectgradevalue_0" id="selectgradevalue" data-value="0" name="grade" required>
                                            <option value="">Select Grade</option>
                                            </select>
                                        </div>
                                        <div class="form-group selectclass notshow" id="divclass" data-id="0">
                                            <label>Class <span class="requried">*</span></label>
                                            <select class="form-control selectclassvalue notshow selectclassvalue_0" id="selectclassvalue" data-value="0" name="class" required>
                                            <option value="">Select Class</option>
                                            </select>
                                        </div>
                                    
                                    <!-- <div class="form-group parent" id ="parent2">
                                    </div>
                                    <div class="form-group">
                                        <p class="set_theme_color add_teacher" ><i class="fa fa-plus"></i> Add another class</p>
                                    </div> -->
                                    <div class="text-primary title-text mb-4 mt-4">STUDENT INFORMATION</div>
                                    <div class="form-group">
                                        <!-- <label>First Name</label> -->
                                        <input type="text" class="form-control" name="first_name" value="" placeholder="First Name" />
                                    </div>
                                     <div class="form-group">
                                        <!-- <label>Last Name</label> -->
                                        <input type="text" class="form-control" name="last_name" value="" placeholder="Last Name" />
                                    </div>
                                    <div class="form-group">
                                       <!--  <label>Phone Number</label> -->
                                        <input type="text" class="form-control" name="mobile_number" value="" placeholder="Phone Number" />
                                    </div>
                                    <div class="form-group">
                                        <!-- <label class="mb-1">Create Password</label> -->
                                        <input type="password" name="password" class="form-control" value="" placeholder="Create Password" />
                                    </div>
                                    <div class="form-group">
                                        <!-- <label class="mb-1" for="password-confirm">Confirm Password</label> -->
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password" />
                                    </div>
                                    <p class="mb-5 mt-5">By clicking "Create account" you agree to our <a class="set_theme_color" href="javascript:void()" >terms and conditions</a> as well as our <a class="set_theme_color" href="javascript:void()" >privacy policy</a></p>
                                    <div class="text-center mt-4 authincation-content">
                                        <button type="submit" class="btn text-white text-primary-k btn-block">Create Account</button>
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
<style type="text/css">
    .authincation-content-s {
    background: #fff;
}
.notshow .dropdown.bootstrap-select.form-control {
    background: transparent;
    border: none;
    padding: 0;
}
.notshow button.btn.dropdown-toggle.btn-light.bs-placeholder {
    display: none;
}
.notshow button.btn.dropdown-toggle.btn-light {
    display: none;
}
.notshow .dropdown-menu.show {
    display: none;
}
.set_theme_color{
    color: #FA8231;
    cursor: pointer;
}
</style>

@endsection
