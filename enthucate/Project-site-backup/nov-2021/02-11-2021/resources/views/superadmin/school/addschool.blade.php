@extends('layouts.superadmin_layout')
@section('title', 'Add School - Enthucate')
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
                        <form method="POST" action="{{ url('/superadmin/save-school' ) }}">
                           @csrf
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Add School</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">School Details</span></div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Organisation <span class="requried">*</span></label>
                                                   <select class="form-control seleorganisation_id" name="organisation">
                                                        <option value="">Select Organisation</option> 
                                                        @if(!empty($organisations))
                                                            @foreach($organisations as $organisation)
                                                                <option value="{{$organisation->id}}">{{$organisation->organisation_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Name Of School <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" name="school_name" id="school_name" value="{{ old('school_name') }}" placeholder="Enter School name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Contact Number <span class="requried">*</span></label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="school_phone" name="school_phone" value="{{ old('school_phone') }}" placeholder="School Phone Number" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>EMIS Number <span class="requried">*</span></label>
                                                    <div class="input-group">
                                                       <input type="text" class="form-control" placeholder="Enter EMIS Number" name="emis_number" value="{{ old('emis_number') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Address <span class="requried">*</span></label>
                                                    <div class="input-group">
                                                       <input type="text" class="form-control" placeholder="Enter address" name="address" value="{{ old('address') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select class="form-control selectcountry" name="country">
                                                        <option value="">Select country</option> 
                                                        @if(!empty($countries))
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 selectstate">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select class="form-control selectstatevalue" id="selectstatevalue" name="state">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 selectcity">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select class="form-control selectcityvalue" id="selectcityvalue" name="city">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Postal Code </label>
                                                    <div class="input-group">
                                                       <input type="text" class="form-control" placeholder="Enter Postal Code" name="postal_code" value="{{ old('postal_code') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Principal Details</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Principal Name <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ old('name') }}"/> 
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number <span class="requried">*</span></label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Phone no." name="mobile_number" value="{{ old('mobile_number') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Whatsapp</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Phone no." name="whatsapp" value="{{ old('whatsapp') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>                                        
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

@endsection
@section('page_script')
@endsection