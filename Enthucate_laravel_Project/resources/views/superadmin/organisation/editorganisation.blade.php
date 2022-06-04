@extends('layouts.superadmin_layout')
@section('title', 'Organisation Edit - Enthucate')
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
            <?php
            $sortname = '';
            $phonecode = App\Models\Country::where('phonecode',$organisations->country_code)->first();
            if(!empty($phonecode)){
               $sortname = $phonecode->sortname; 
            }

            ?>
                <div class="row">                
                    <div class="col-xl-12">
                         <form method="POST" action="{{ url('/superadmin/update-organisation/'.$organisations->id ) }}">
                           @csrf
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Organisation</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Generals</span></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Name Of Organisation *</label>
                                                    <input type="text" class="form-control" placeholder="Enter name"  name="organisation_name" value="{{ $organisations->organisation_name }}" />
                                                </div>
                                            </div>
                                           <!--  <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Level Name *</label>
                                                    <select class="form-control level_name" name="level_name" >
                                                        <option value="">Select Level Name</option>
                                                        @if(!empty($hierarchys))
	                                                        @foreach($hierarchys as $hierarchy)
	                                                        	<option value="{{$hierarchy->id}}" @if($hierarchy->id == $organisations->hierarchy_id) selected @endif>{{$hierarchy->level_name}}</option>
	                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div> -->
                                            <!--  <div class="col-sm-4 Subdivision_main" @if($organisations->parent_id != Auth::User()->id) style="display:block; @endif">
                                             @if(!empty($suborganisations))
                                              <div class="form-group">
                                                    <label>Sub division *</label>
                                                    <select class="form-control Subdivisiontype" name="parent_id" >
                                                         <option value="">Select License Type</option>
                                                            @foreach($suborganisations as $suborganisation)
                                                                <option value="{{$suborganisation->id}}" @if($suborganisation->id == $user->organisation_id) selected @endif>{{$suborganisation->organisation_name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                              @endif  
                                            </div> -->
                                           <!--  <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>License Type *</label>
                                                    <select class="form-control" name="license_type" >
	                                                     <option value="">Select License Type</option>
	                                                    @if(!empty($hierarchyLicense))
		                                                    @foreach($hierarchyLicense as $hierarchy)
		                                                    	<option value="{{$hierarchy->id}}" @if($hierarchy->id == $organisations->license_type) selected @endif>{{$hierarchy->license_type}}</option>
		                                                    @endforeach
	                                                	@endif
                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Primary Contact Details</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $organisations->name }}" />
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" placeholder="User name" name="username" value="{{ $organisations->username }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Position Title</label>
                                                    <input type="text" class="form-control" placeholder="Position Title" name="position_title" value="{{ $organisations->position_title }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Secondary CONTACT DETAILS</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                        <div class="country_code">
                                                        <input type="hidden" name="country_code" class="country_code" id="country_code" value="{{$organisations->country_code}}">
                                                        
                                                        </div>
                                                        <input type="text" class="form-control pl-3" placeholder="Phone no." name="mobile_number"  id="mobile_number" value=""/>
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
                                                        <input type="text" class="form-control" placeholder="Phone no." name="whatsapp" value="{{ $organisations->whatsapp }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Enter email" name="email" value="{{ $organisations->email }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Office Address</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Enter address" name="address" value="{{ $organisations->address }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select class="form-control selectcountry" name="country">
                                                        <option value="">Select country</option> 
                                                        @if(!empty($countries))
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->id}}" @if($organisations->country == $country->id) selected @endif >{{$country->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 selectstate">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select class="form-control selectstatevalue" id="selectstatevalue" name="state">
                                                        <option value="">Select State</option> 
                                                        @if(!empty($states))
                                                            @foreach($states as $state)
                                                                <option value="{{$state->id}}" @if($organisations->state == $state->id) selected @endif >{{$state->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 selectcity">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select class="form-control selectcityvalue" id="selectcityvalue" name="city">
                                                        <option value="">Select City</option> 
                                                        @if(!empty($cities))
                                                            @foreach($cities as $city)
                                                                <option value="{{$city->id}}" @if($organisations->city == $city->id) selected @endif >{{$city->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
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
    var mobile_number = '<?php echo $organisations->mobile_number; ?>';
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