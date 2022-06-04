@extends('layouts.app') @section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center user_type_login">
            <div class="col-md-6">
            <div class="invitemembererror"></div>
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
                <form method="post" action="{{url('create-parent-account')}}" enctype="multipart/form-data" autocomplete="off">
                    <div class="tab_1_parent" id="tab_1_parent">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-3">
                                            <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                        </div>
                                        <h4 class="text-center text-white">Create account for Parent</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="authincation-content-s">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form parentform">
                                        @csrf
                                        <input type="hidden" id="parent_id" name="id" value="{{$user->id}}" />
                                        <input type="hidden" name="type" value="crateorganisation" />
                                        <input type="hidden" class="form-control" name="email" value="{{$user->email}}" />
                                        <div class="text-primary title-text mb-4">PARENT INFORMATION</div>
                                        <div class="form-group">
                                            <!-- <label>First Name</label> -->
                                            <input type="text" class="form-control first_name" name="first_name" value="" placeholder="First Name" required />
                                        </div>
                                        <div class="form-group">
                                            <!-- <label>Last Name</label> -->
                                            <input type="text" class="form-control last_name" name="last_name" value="" placeholder="Last Name" required />
                                        </div>
                                        <div class="form-group">
                                            <!--  <label>Phone Number</label> -->
                                            <input type="text" class="form-control mobile_number" name="mobile_number" value="" placeholder="Phone Number" required />
                                        </div>
                                        <div class="form-group">
                                            <!-- <label class="mb-1">Create Password</label> -->
                                            <input type="password" class="form-control password" name="password" class="form-control" value="" placeholder="Create Password" required />
                                        </div>
                                        <div class="form-group">
                                            <!-- <label class="mb-1" for="password-confirm">Confirm Password</label> -->
                                            <input id="password-confirm" type="password" class="form-control password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password" required />
                                            <div class="passerror"></div>
                                        </div>
                                        <p class="mb-5 mt-5">
                                            By clicking "Create account" you agree to our <a class="set_theme_color" href="javascript:void()">terms and conditions</a> as well as our
                                            <a class="set_theme_color" href="javascript:void()">privacy policy</a>
                                        </p>
                                        <div class="text-center mt-4 authincation-content">
                                            <button type="submit" class="btn text-white text-primary-k btn-block add_child" class="btn btn-danger shadow btn-xs sharp markschooldelete" title="Create Account" data-placement="right">Create Account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end tab 1 --> 
                    <div class="tab_3_parent" id="tab_3_parent" style="display: none;">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-3">
                                            <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                        </div>
                                        <h4 class="text-center text-white">Add Child</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="authincation-content-s">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form parentform">
                                        <div class="text-primary title-text mb-4">GENERAL INFO</div>
                                        <div id="get_student_info">
                                            <div class="form-group add_student_info" >
                                                <span class="mt-5">Name</span>
                                                <div class="student_school">Rohit Bhatia</div>
                                                <span class="mt-5">School</span>
                                                <div class="student_school">Rohit Bhatia</div>
                                            </div>
                                        </div>
                                        <div id="get_student_id"></div>
                                         <p class="add_onther_child" class="btn btn-danger shadow btn-xs sharp">Add another child</p>

                                         <div class="text-center mt-4 authincation-content">
                                        <button type="submit" class="btn text-white text-primary-k btn-block">Finish</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                  
                </form>
                 <div class="tab_2_parent" id="tab_2_parent" style="display: none;">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-3">
                                            <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                        </div>
                                        <h4 class="text-center text-white">Add New Child</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="#" enctype="multipart/form-data" autocomplete="off" class="add_child_form">
                        <div class="authincation-content-s">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form parentform">
                                        @csrf   
                                         <input type="hidden" id="parent_id" name="parent_id" value="{{$user->id}}" />
                                        <div class="text-primary title-text mb-4">CHILD INFORMATION</div>
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
                                        <div class="form-group">
                                            <!-- <label>First Name</label> -->
                                            <input type="text" class="form-control child_first_name" name="child_first_name" value="" placeholder="First Name" required />
                                        </div>
                                        <div class="form-group">
                                            <!-- <label>Last Name</label> -->
                                            <input type="text" class="form-control child_last_name" name="child_last_name" value="" placeholder="Last Name" required />
                                        </div>
                                        <div class="form-group">
                                            <!--  <label>Phone Number</label> -->
                                            <input type="text" class="form-control child_mobile_number" name="mobile_number" value="" placeholder="Phone Number" required />
                                        </div>
                                        <div class="form-group">
                                            <!-- <label class="mb-1">Create Password</label> -->
                                            <input type="email" class="form-control child_email" name="email" class="form-control" value="" placeholder="Email" required />
                                        </div>
                                        <div class="text-center mt-4 authincation-content">
                                            <button type="button" class="btn text-white text-primary-k btn-block add_new_child">Add Child</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- end tab 2 with new child -->
                    <div class="tab_4_parent" id="tab_4_parent" style="display: none;">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-3">
                                            <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                        </div>
                                        <h4 class="text-center text-white">Join ID</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <form method="post" action="#" enctype="multipart/form-data" autocomplete="off" class="exist_child_form">
                        <div class="authincation-content-s">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form parentform">
                                    @csrf
                                     <p>Please put a link to register your child in this field</p>
                                        <div class="form-group">
                                            <!-- <label>First Name</label> -->
                                            <input type="text" class="form-control join_id" name="join_id" value="" placeholder="Join ID" required />
                                        </div>
                                        <div class="text-center mt-4 authincation-content">
                                            <button type="button" class="btn text-white text-primary-k btn-block exist_new_child">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- end tab 4 with exist child -->
                     <div class="tab_5_parent" id="tab_5_parent" style="display: none;">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-3">
                                            <a href="javascript:void(0)"><img src="{{ asset('public/assets/images/logo.png') }}" alt="" /></a>
                                        </div>
                                        <h4 class="text-center text-white">Add new child by link</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="authincation-content-s">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form parentform">
                                        <div class="text-primary title-text mb-4">GENERAL INFORMATION</div>
                                        <div id="getexist_student_info">
                                            <div class="form-group " >
                                            </div>
                                        </div>
                                        <div id="get_student_info_input">
                                        </div>
                                         <div class="text-center mt-4 authincation-content">
                                        <button type="button" class="btn text-white text-primary-k btn-block my_child">Add Child</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addchildcall" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Add child</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Do you have a link to register a child?                                    
         </div>
         <form class="form" method="POST" id="schooldelete" action="#">
            @csrf
            <input type="hidden" name="school_id" id="school_id" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2 nochild">No</button>
               <button type="button" class="btn btn-primary btn-rounded mb-2 yeschild">YES, I HAVE A LINK</button>
            </div>
         </form>
      </div>
   </div>
</div>
<style type="text/css">
p.add_onther_child {
    text-align: center;
    padding: 17px;
    border: 2px dotted #F76828;
    color: #F76828;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
}
.form-group.add_student_info {
    padding: 25px;
    background-color: rgba(251, 251, 251, 1);
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.149019607843137);
    color: #828282;
    font-size: 14px;
}
.add_student_info .student_school {
    margin-top: 5px;
    margin-bottom: 15px;
    font-size: 16px;
    color: #000;
    font-weight: 400;
}
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
    .set_theme_color {
        color: #fa8231;
        cursor: pointer;
    }
</style>

@endsection
