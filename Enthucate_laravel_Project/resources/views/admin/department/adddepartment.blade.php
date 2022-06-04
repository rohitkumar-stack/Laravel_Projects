@extends('layouts.admin_layout')
@section('title', 'Department Add - Enthucate')
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
                         <form method="POST" action="{{ url(Auth::User()->organisation_url.'/admin/save-department' ) }}">
                           @csrf
                           <!-- <input type="hidden" name="organisation" value="{{Auth::User()->organisation_id}}"> -->
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Add Department</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="submit" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="row">
                                        <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Organisation <span class="requried">*</span></label>
                                                   <select class="form-control seleorganisation_id" name="organisation" id="seleorganisationid">
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
                                                    <label>Department *</label>
                                                    <input type="text" class="form-control" placeholder="Enter name"  name="department_name" value="{{ old('department_name') }}"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" placeholder="Enter Description" name="description" value="{{ old('description') }}"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Members</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <select name="members[]" multiple="" class="form-control selectmembervalue"  tabindex="-98" id="selectmembervalue">
                                                            <option value="">Select Members</option> 
                                                            @if(!empty($members))
                                                                @foreach($members as $member)
                                                                    <option value="{{$member->id}}">{{$member->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Message Create Members </label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <select name="create_members[]" multiple="" class="form-control" id="sel2" tabindex="-98">
                                                            <option value="">Select Create Members</option> 
                                                            @if(!empty($members))
                                                                @foreach($members as $member)
                                                                    <option value="{{$member->id}}">{{$member->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> -->
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