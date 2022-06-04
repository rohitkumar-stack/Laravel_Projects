@extends('layouts.admin_layout')
@section('title', 'Edit Users - Enthucate')
@section('content')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-lg-12">
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
                @endif
                <div class="row">
                    <div class="col-xl-12">
                         <form method="POST" action="{{ url(Auth::User()->organisation_url.'/admin/update-user/'.$user->id ) }}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <?php
                            $schoolid = array();
                            if($user->school_id != ''){
                                $schoolid = explode(',', $user->school_id);
                            }
                            $sortname = '';
                            $phonecode = App\Models\Country::where('phonecode',$user->country_code)->first();
                            if(!empty($phonecode)){
                               $sortname = $phonecode->sortname; 
                            }
                            ?>
                            <input type="hidden" name="organisation" value="{{$user->organisation_id}}">
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Users</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save/Send</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Create Users</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Full Name <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $user->name }}"/>
                                                </div>
                                            </div>

                                            <!-- <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Username <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" placeholder="User name" name="username" value="{{ $user->username }}"/>
                                                </div>
                                            </div> -->
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Position Title</label>
                                                    <input type="text" class="form-control" placeholder="Position Title" name="position_title" value="{{ $user->position_title }}"/>
                                                </div>
                                            </div>
                                            <!-- <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Position</label>
                                                    <input type="text" class="form-control" placeholder="Enter Position" />
                                                </div>
                                            </div> -->
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Role <span class="requried">*</span></label>
                                                        <select class="form-control selerole_id" id="selerole" name="role">
                                                        <option value="">Select Role</option> 
                                                        @if(!empty($roletypes))
                                                            @foreach($roletypes as $roletype)
                                                                  @if($roletype->id != '9' && $roletype->id != '10' && $roletype->id != '11')
                                                                    <option @if($user->role_id == $roletype->id) selected @endif value="{{$roletype->id}}">{{$roletype->role}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                           <!--  <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Organisation <span class="requried">*</span></label>
                                                    <select class="form-control seleorganisation_id" id="seleorganisationid" name="organisation">
                                                        <option value="">Select Organisation</option> 
                                                        @if(!empty($organisations))
                                                            @foreach($organisations as $organisation)
                                                                <option value="{{$organisation->id}}">{{$organisation->organisation_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div> -->
                                             <!-- <div class="col-xl-4 col-sm-6 selectdepartment">
                                                <div class="form-group">
                                                    <label>Department <span class="requried">*</span></label>
                                                    <select class="form-control selectdepartmentvalue" id="selectdepartmentvalue" name="department">
                                                    <option value="">Select Department</option>
                                                    @if(!empty($departments))
                                                            @foreach($departments as $department)
                                                                <option value="{{$department->id}}"  @if($user->department_id == $department->id) selected @endif >{{$department->department_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>  -->
                                            <div class="col-xl-4 col-sm-6 selectschool userschool" @if($user->role_id != 2 && $user->role_id != 6 && $user->role_id != 8) style="display:block" @else style="display:none" @endif>
                                                <div class="form-group">
                                                    <label>School <span class="requried">*</span></label>
                                                    <select class="form-control selectschoolvalue" id="selectschoolvalue" name="school[]" multiple="">
                                                    <option value="">Select School</option>
                                                    @if(!empty($schools))
                                                            @foreach($schools as $school)
                                                                <option @if($user->role_id == $roletype->id) selected @endif value="{{$roletype->id}}">{{$roletype->role}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Email Address <span class="requried">*</span></label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Enter email" name="email" value="{{ $user->email }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number <span class="requried">*</span></label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                      <input type="hidden" name="country_code" class="country_code" id="country_code" value="{{$user->country_code}}">
                                                      
                                                        <input type="text" class="form-control pl-3" placeholder="Phone no." name="mobile_number" id="mobile_number" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number (Whatsapp)</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                                        </div>

                                                        <input type="text" class="form-control" placeholder="Phone no." name="whatsapp" value="{{ $user->whatsapp }}" />
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('public/assets/css/intlTelInput.css') }}">
@endsection
@section('page_script')
  <script src="{{ asset('public/assets/js/intlTelInput.js') }}"></script>
<script>

$(window).on('load', function() {
    var mobile_number = '<?php echo $user->mobile_number; ?>';
    var sortname = '<?php echo $sortname; ?>';
  $(document).on("click", ".iti__country", function () {
    var code = $(this).attr('data-dial-code');
    $('#country_code').val(code);
  })
    var input = document.querySelector("#mobile_number");
    window.intlTelInput(input, {        
      geoIpLookup: function(callback) {
        if(sortname == ''){
              $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
              setTimeout(function () {
              var code = $('li.iti__country.iti__standard.iti__active').attr('data-dial-code');
              $('#country_code').val(code);
              $('#mobile_number').val(mobile_number);
            }, 100);
            });  
        }
        else{
            var countryCode = sortname;
              callback(countryCode);
              setTimeout(function () {
              var code = $('li.iti__country.iti__standard.iti__active').attr('data-dial-code');
              $('#country_code').val(code);
              $('#mobile_number').val(mobile_number);
            }, 100);
        }
        
      },
      initialCountry: "auto",
      utilsScript: "{{ asset('public/assets/js/utils.js') }}",
    });
    });
  </script>
@endsection